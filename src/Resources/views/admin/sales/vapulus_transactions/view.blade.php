@extends('admin::layouts.master')

@section('page_title')
    {{ __('vapulus::app.admin.sales.transactions.view-title', ['transaction_id' => $transaction->transaction_id]) }}
@stop

@section('content-wrapper')

    <div class="content full-page">

        <div class="page-header">

            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/sales/vapulus_transactions') }}';"></i>

                    {{ __('vapulus::app.admin.sales.transactions.view-title', ['transaction_id' => $transaction->transaction_id]) }}
                </h1>
            </div>
        </div>

        <div class="page-content">

            <tabs>
                {!! view_render_event('vapulus.sales.transaction.tabs.before', ['transactionInfo' => $transactionInfo]) !!}

                <tab name="{{ __('vapulus::app.admin.sales.transactions.transaction-info') }}" :selected="true">
                    <div class="sale-container">

                        <accordian :title="'{{ __('vapulus::app.admin.sales.transactions.transaction-info') }}'" :active="true">
                            <div slot="body">

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>{{ __('vapulus::app.admin.sales.transactions.response-info') }}</span>
                                    </div>

                                    <div class="section-content">
                                        @if ( isset($transactionInfo['statusCode']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.status-code') }}
                                                </span>

                                                <span class="value">
                                                    {{ $transactionInfo['statusCode'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($transactionInfo['message']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.message') }}
                                                </span>

                                                <span class="value">
                                                    {{ $transactionInfo['message'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <?php $trans_data = isset($transactionInfo['data']) ? $transactionInfo['data'] : []; ?>

                                <div class="sale-section">
                                    <div class="secton-title">
                                        <span>{{ __('vapulus::app.admin.sales.transactions.transaction-info') }}</span>
                                    </div>

                                    <div class="section-content">
                                        @if ( isset($trans_data['amount']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.amount') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['amount'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['status']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.status') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['status'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['transactionType']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.transaction-type') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['transactionType'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['serviceId']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.service-id') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['serviceId'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['serviceType']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.service-type') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['serviceType'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['offerId']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.offer-id') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['offerId'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['offerType']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.offer-type') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['offerType'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['accountType']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.account-type') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['accountType'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['destinationType']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.destination-type') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['destinationType'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['production']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.production') }}
                                                </span>

                                                <span class="value">
                                                    @if ($trans_data['production'] == true)
                                                        {{ 'Yes' }}
                                                    @else 
                                                        {{ 'No' }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif

                                        @if ( isset($trans_data['mobileNumber']))
                                            <div class="row">
                                                <span class="title">
                                                    {{ __('vapulus::app.admin.sales.transactions.mobile-number') }}
                                                </span>

                                                <span class="value">
                                                    {{ $trans_data['mobileNumber'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </accordian>

                    </div>
                </tab>

                {!! view_render_event('vapulus.sales.transaction.tabs.after', ['transactionInfo' => $transactionInfo]) !!}
            </tabs>
        </div>

    </div>
@stop
