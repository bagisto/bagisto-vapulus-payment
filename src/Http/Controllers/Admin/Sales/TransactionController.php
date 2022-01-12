<?php

namespace Webkul\Vapulus\Http\Controllers\Admin\Sales;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Vapulus\Repositories\VapulusRepository;
use Webkul\Vapulus\Helpers\Helper as VapulusHelper;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * VapulusHelper object
     *
     * @var \Webkul\Vapulus\Helpers\Helper  $vapulusHelper
     */
    protected $vapulusHelper;

    /**
     * VapulusRepository object
     *
     * @var \Webkul\Vapulus\Repositories\VapulusRepository
     */
    protected $vapulusRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Vapulus\Helpers\Helper  $vapulusHelper
     * @param  \Webkul\Vapulus\Repositories\VapulusRepository  $vapulusRepository
     * @return void
     */
    public function __construct(
        VapulusHelper $vapulusHelper,
        VapulusRepository $vapulusRepository
    )   {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->vapulusHelper = $vapulusHelper;

        $this->vapulusRepository = $vapulusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $transaction_id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $secure_hash = core()->getConfigData('sales.paymentmethods.vapulus.secure_hash');
        $app_id = core()->getConfigData('sales.paymentmethods.vapulus.app_id');
        $password = core()->getConfigData('sales.paymentmethods.vapulus.password');

        if (! $secure_hash || ! $app_id || ! $password ) {
            session()->flash('error', trans('vapulus::app.admin.sales.transactions.error-config-missing'));

            return redirect()->route('admin.sales.vapulus_transactions.index');
        }

        $transaction = $this->vapulusRepository->findOrFail($id);
        
        if ( isset($transaction->transaction_id)) {
            try {
                $postData = array(
                    'transactionId' => $transaction->transaction_id
                );
                
                $postData['hashSecret'] = $this->vapulusHelper->generateHash($secure_hash, $postData);
                
                $postData['appId'] = $app_id;
                $postData['password'] = $password;
                
                $output = $this->vapulusHelper->HTTPPost('app/transactionInfo', $postData);
                
                $transactionInfo = json_decode($output, true);
    
                return view($this->_config['view'], compact('transactionInfo', 'transaction'));
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());

                return redirect()->route('admin.sales.vapulus_transactions.index');
            }
        } else {
            session()->flash('error', trans('vapulus::app.admin.sales.transactions.error-missing-transaction'));

            return redirect()->route('admin.sales.vapulus_transactions.index');
        }
    }
}