<?php $cart = cart()->getCart(); ?>

@if ($cart)
    
    @php
        $websiteId = core()->getConfigData('sales.paymentmethods.vapulus.website_id');
        $vapulus_currency_code = core()->getConfigData('sales.paymentmethods.vapulus.currency_code');
        $cart_total = core()->convertPrice($cart->grand_total, $vapulus_currency_code, core()->getCurrentCurrencyCode());
        $total = number_format((float)$cart_total, 2, '.', '');
    @endphp

    @if ( request()->is('checkout/redirect/vapulus') && core()->getConfigData('sales.paymentmethods.vapulus.active') )
        <html>

            <head>
                <title>{{ __('vapulus::app.shop.checkout.page-title') }}</title>
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <link rel="icon" href="https://www.vapulus.com/favicon.ico" type="image/x-icon"/>
            
                <link href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                <link href="{{ asset('vendor/webkul/vapulus/assets/css/vapulus.css') }}" rel="stylesheet"/>
            </head>

            <body style="background-color: #f8f9fa;">
                <!-- CREATE THE HTML FOR THE PAYMENT PAGE -->
                <div class="vapulus-card-shadow">
                    <div class="row">
                        <a href="{{ route('vapulus.payment.cancel') }}" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>

                        <div class="vapulus-logo">
                            <img class="mx-auto d-block" src="{{ asset('vendor/webkul/vapulus/assets/images/vapulus-logo.png') }}" style="height: 70px;"/>
                        </div>

                        <div id="vapulus-payment-form">
                            <div class="contents">
                                <h3 class="summary-heading">{{ __('velocity::app.checkout.cart.cart-summary') }}</h3>
                            
                                <div class="row">
                                    <div class="col-8">{{ __('velocity::app.checkout.sub-total') }}</div>
                                    <div class="col-4 text-right">{{ core()->currency($cart->base_sub_total) }}</div>
                                </div>
                            
                                @if ($cart->selected_shipping_rate)
                                    <div class="row">
                                        <div class="col-8">{{ __('shop::app.checkout.total.delivery-charges') }}</div>
                                        <div class="col-4 text-right">{{ core()->currency($cart->selected_shipping_rate->base_price) }}</div>
                                    </div>
                                @endif
                            
                                @if ($cart->base_tax_total)
                                    @foreach (Webkul\Tax\Helpers\Tax::getTaxRatesWithAmount($cart, true) as $taxRate => $baseTaxAmount )
                                        <div class="row">
                                            <div class="col-8" id="taxrate-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ __('shop::app.checkout.total.tax') }} {{ $taxRate }} %</div>
                                            <div class="col-4 text-right" id="basetaxamount-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ core()->currency($baseTaxAmount) }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            
                                @if (
                                    $cart->base_discount_amount
                                    && $cart->base_discount_amount > 0
                                )
                                    <div
                                        id="discount-detail"
                                        class="row">
                            
                                        <div class="col-8">{{ __('shop::app.checkout.total.disc-amount') }}</div>
                                        <div class="col-4 text-right">
                                            -{{ core()->currency($cart->base_discount_amount) }}
                                        </div>
                                    </div>
                                @endif
                            
                                <div class="payable-amount row" id="grand-total-detail">
                                    <div class="col-8">{{ __('shop::app.checkout.total.grand-total') }}</div>
                                    <div class="col-4 text-right fw6" id="grand-total-amount-detail">
                                        {{ core()->currency($cart->base_grand_total) }}
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <!-- vapulus pay btn script -->
                                    <script id="vapulusScript" 
                                    vapulusId="{{ $websiteId }}" 
                                    amount="{{ $total }}" 
                                    onaccept="{{ route('vapulus.make.payment') }}" 
                                    onfail="{{ route('vapulus.payment.cancel') }}" 
                                    src="https://storage.googleapis.com/vapulus-website/script.js"></script>
                                    <!-- /vapulus pay btn script -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
        </html>

    @endif
@endif