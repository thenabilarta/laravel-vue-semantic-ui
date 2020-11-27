<?php

namespace Modules\Platform\Core\Datatable;

use Modules\Platform\Core\Helper\DataTableHelper;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

/**
 * Class PlatformDataTable
 * @package Modules\Platform\Core\Datatable
 */
abstract class PlatformDataTable extends DataTable
{
    protected $sourceRoute;

    protected $tableId;

    /**
     * @param $route
     */
    public function setAjaxSource($route)
    {
        $this->sourceRoute = $route;
    }

    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }

    /**
     * @return \Yajra\DataTables\Html\Builder
     */
    public function builder()
    {
        $builder = parent::builder();

        if ($this->tableId != '') {
            $builder = $builder->setTableId($this->tableId);
        }
        if ($this->sourceRoute != '') {
            $builder = $builder->ajax($this->sourceRoute);
        }



        return $builder;
    }

    /**
     * @param EloquentDataTable $table
     * @param $route
     * @param null $prefix
     */
    public function applyLinks(EloquentDataTable $table, $route, $prefix = null)
    {
        $rawColumns = [];

        $table->addRowAttr('record-id', function ($record) {
            return $record->id;
        });

        $table->addRowAttr('record-type', function ($record) {
            return get_class($record);
        });

        foreach ($this->getColumns() as $column => $properties) {
            $rawColumns[] = $column;

            $table->editColumn($column, function ($record) use ($column, $properties, $route, $prefix) {
                return DataTableHelper::renderLink($column, $record, $properties, $route, $prefix);
            });
        }

        $table->rawColumns($rawColumns);
    }

    /**
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }
}
