@extends('admin::layouts.content')

@section('page_title')
    {{ __('vapulus::app.admin.sales.transactions.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('vapulus::app.admin.sales.transactions.title') }}</h1>
            </div>
        </div>

        <div class="page-content">
            @inject('vapulusTransactionDataGrid', 'Webkul\Vapulus\DataGrids\Admin\VapulusTransactionDataGrid')
            {!! $vapulusTransactionDataGrid->render() !!}
        </div>
    </div>
@stop