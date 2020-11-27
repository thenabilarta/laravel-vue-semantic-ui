<?php

namespace Modules\Platform\Settings\Datatables;

use Modules\Platform\Core\Datatable\PlatformDataTable;
use Modules\Platform\Core\Helper\DataTableHelper;
use Modules\Platform\Settings\Entities\Currency;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class CurrencyDatatable
 * @package Modules\Platform\Settings\Datatables
 */
class CurrencyDatatable extends PlatformDataTable
{
    const SHOW_URL_ROUTE = 'settings.currency.show';


    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);


        $this->applyLinks($dataTable, self::SHOW_URL_ROUTE);

        $dataTable->filterColumn('created_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('created_at', array($dates[0], $dates[1]));
            }
        });
        $dataTable->filterColumn('updated_at', function ($query, $keyword) {
            $dates = DataTableHelper::getDatesForFilter($keyword);

            if ($dates != null) {
                $query->whereBetween('updated_at', array($dates[0], $dates[1]));
            }
        });

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Currency $model)
    {
        return $model->disableModelCaching()->newQuery()->select();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->setTableAttribute('class', 'table table-hover')
            ->parameters([
                'dom' => 'lBfrtip',
                'responsive' => false,
                'stateSave' => true,
                'columnFilters' => [
                    [
                        'column_number' => 0,
                        'filter_type' => 'text'
                    ],
                    [
                        'column_number' => 1,
                        'filter_type' => 'text'
                    ],
                    [
                        'column_number' => 2,
                        'filter_type' => 'text'
                    ],
                    [
                        'column_number' => 3,
                        'filter_type' => 'bap_date_range_picker',

                    ],
                    [
                        'column_number' => 4,
                        'filter_type' => 'bap_date_range_picker',
                    ]
                ],
                'buttons' => DataTableHelper::buttons(),
                'regexp' => true

            ]);
    }

    /**
     * @return array
     */
    protected function getColumns()
    {
        return
            [
                'name' => ['data' => 'name', 'title' => trans('settings::currency.table.name'), 'data_type' => 'text'],
                'code' => ['data' => 'code', 'title' => trans('settings::currency.table.code'), 'data_type' => 'text'],
                'symbol' => ['data' => 'symbol', 'title' => trans('settings::currency.table.symbol'), 'data_type' => 'text'],
                'created_at' => ['data' => 'created_at', 'title' => trans('settings::currency.table.created_at'), 'data_type' => 'datetime'],
                'updated_at' => ['data' => 'updated_at', 'title' => trans('settings::currency.table.updated_at'), 'data_type' => 'datetime']
            ];
    }
}
