<?php

namespace Webkul\Vapulus\DataGrids\Admin;

use Illuminate\Support\Facades\DB;
use Webkul\Sales\Models\OrderAddress;
use Webkul\Ui\DataGrid\DataGrid;

class VapulusTransactionDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('orders')
            ->leftJoin('addresses as order_address_shipping', function($leftJoin) {
                $leftJoin->on('order_address_shipping.order_id', '=', 'orders.id')
                    ->where('order_address_shipping.address_type', OrderAddress::ADDRESS_TYPE_SHIPPING);;
            })
            ->leftJoin('addresses as order_address_billing', function($leftJoin) {
                $leftJoin->on('order_address_billing.order_id', '=', 'orders.id')
                ->where('order_address_billing.address_type', OrderAddress::ADDRESS_TYPE_BILLING);
            })
            ->leftJoin('vapulus_transactions as vt', 'orders.id', '=', 'vt.order_id')
            ->addSelect('vt.id', 'orders.increment_id', 'orders.base_sub_total', 'orders.base_grand_total', 'orders.created_at', 'vt.order_id', 'vt.status', 'vt.transaction_id')
            ->whereNotNull('vt.id');
        
        $this->addFilter('transaction_id', 'vt.transaction_id');
        $this->addFilter('order_id', 'vt.order_id');
        $this->addFilter('increment_id', 'orders.increment_id');
        $this->addFilter('status', 'vt.status');
        $this->addFilter('created_at', 'orders.created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'transaction_id',
            'label'      => trans('vapulus::app.admin.sales.transactions.transaction-id'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'increment_id',
            'label'      => trans('vapulus::app.admin.sales.transactions.order-id'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'base_sub_total',
            'label'      => trans('admin::app.datagrid.sub-total'),
            'type'       => 'price',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'base_grand_total',
            'label'      => trans('admin::app.datagrid.grand-total'),
            'type'       => 'price',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.datagrid.status'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'closure'    => true,
            'filterable' => true,
            'wrapper' => function ($row) {
                return '<span class="badge badge-md badge-success">'. ucfirst($row->status) .'</span>';
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.datagrid.order-date'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'admin.sales.vapulus_transactions.view',
            'icon'   => 'icon eye-icon',
        ]);
    }
}