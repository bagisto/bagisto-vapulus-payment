<?php

namespace Webkul\Vapulus\Http\Controllers;

use Webkul\Vapulus\Helpers\Helper as VapulusHelper;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Vapulus\Repositories\VapulusRepository;
use Illuminate\Support\Facades\Log;

class VapulusController extends Controller
{
    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;
    
    /**
     * VapulusRepository object
     *
     * @var \Webkul\Vapulus\Repositories\VapulusRepository
     */
    protected $vapulusRepository;

    /**
     * VapulusHelper object
     *
     * @var \Webkul\Vapulus\Helpers\Helper
     */
    protected $vapulusHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Vapulus\Repositories\VapulusRepository  $vapulusRepository
     * @param  \Webkul\Vapulus\Helpers\Helper  $vapulusHelper
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        VapulusRepository $vapulusRepository,
        VapulusHelper $vapulusHelper
    )   {
        $this->orderRepository = $orderRepository;

        $this->vapulusRepository = $vapulusRepository;

        $this->vapulusHelper = $vapulusHelper;
    }

    /**
     * Prepares order's
     *
     * @return json
    */
    public function createCharge()
    {
        $data = request()->all();

        if ( isset($data['transactionId']) && $data['transactionId'] ) {
            $transInfo = $this->getTransactionDetail($data['transactionId']);

            $cart = Cart::getCart();
            if ( $cart && isset($transInfo['status']) && $transInfo['status'] && isset($transInfo['transaction'])) {
                $transactionInfo = $transInfo['transaction'];
                $vapulus_currency_code = core()->getConfigData('sales.paymentmethods.vapulus.currency_code');

                $cart_total = core()->convertPrice($cart->grand_total, $vapulus_currency_code, core()->getCurrentCurrencyCode());
                $total = number_format((float)$cart_total, 2, '.', '');

                if ( isset($transactionInfo['statusCode']) && $transactionInfo['statusCode'] == 200 ) {

                    if ( isset($transactionInfo['data']['amount']) && $transactionInfo['data']['amount'] == $total ) {
                        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

                        $this->order = $this->orderRepository->findOneWhere([
                            'cart_id' => Cart::getCart()->id
                        ]);

                        $this->orderRepository->update(['status' => 'processing'], $this->order->id);

                        $this->invoiceRepository = app('Webkul\Sales\Repositories\InvoiceRepository');

                        if ($this->order->canInvoice()) {
                            $this->invoiceRepository->create($this->prepareInvoiceData());
                        }

                        $this->vapulusRepository->create([
                            'transaction_id'    => $data['transactionId'],
                            'status'            => isset($data['status']) ? $data['status'] : 'approved',
                            'order_id'          => $order->id,
                        ]);

                        Cart::deActivateCart();

                        session()->flash('order', $order);

                        return redirect()->route('shop.checkout.success'); 
                    } else {
                        session()->flash('error', trans('vapulus::app.shop.checkout.error-transaction-fraud'));
                
                        return redirect()->route('shop.checkout.cart.index');
                    }
                } else {
                    session()->flash('error', trans('vapulus::app.shop.checkout.error-transaction-failed'));
                
                    return redirect()->route('shop.checkout.cart.index');
                }
            } else {
                session()->flash('error', trans('vapulus::app.shop.checkout.error-cart-empty'));
            
                return redirect()->route('shop.checkout.cart.index');
            }
        } else {
            session()->flash('error', trans('vapulus::app.shop.checkout.error-payment-cancel'));
            
            return redirect()->route('shop.checkout.cart.index');
        }
    }

    /**
    * Prepares order's invoice data for creation
    *
    * @return array
    */
   public function prepareInvoiceData()
   {
       $invoiceData = [
           "order_id" => $this->order->id
       ];

       foreach ($this->order->items as $item) {
           $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
       }

       return $invoiceData;
   }

    /**
     * Redirects to the vapulus.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        $website_id = core()->getConfigData('sales.paymentmethods.vapulus.website_id');
        

        if (! $website_id) {

            session()->flash('error', trans('vapulus::app.shop.checkout.error-website-id'));

            return redirect()->route('shop.checkout.cart.index');

        } else {
            return view('vapulus::shop.checkout.vapulus');
        }
    }

    /**
     * Cancel payment from Vapulus.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', trans('vapulus::app.shop.checkout.error-payment-cancel'));

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $transaction_id
     * @return array|mix
     */
    public function getTransactionDetail($transaction_id)
    {
        $secure_hash = core()->getConfigData('sales.paymentmethods.vapulus.secure_hash');
        $app_id = core()->getConfigData('sales.paymentmethods.vapulus.app_id');
        $password = core()->getConfigData('sales.paymentmethods.vapulus.password');

        if (! $secure_hash || ! $app_id || ! $password ) {
            return [
                'status'        => false,
                'transaction'   => trans('vapulus::app.admin.sales.transactions.error-config-missing'),
            ];
        }
        
        if ( $transaction_id ) {
            try {
                $postData = array(
                    'transactionId' => $transaction_id,
                    'hashSecret'    => $this->vapulusHelper->generateHash($secure_hash, ['transactionId' => $transaction_id]),
                    'appId'         => $app_id,
                    'password'      => $password,
                );
                
                $output = $this->vapulusHelper->HTTPPost('app/transactionInfo', $postData);
                
                $transactionInfo = json_decode($output, true);

                return [
                    'status'        => true,
                    'transaction'   => $transactionInfo,
                ];
            } catch (\Exception $e) {
                return [
                    'status'        => false,
                    'transaction'   => $e->getMessage(),
                ];
            }
        } else {
            return [
                'status'        => false,
                'transaction'   => trans('vapulus::app.admin.sales.transactions.error-missing-transaction'),
            ];
        }
    }
}