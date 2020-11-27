<?php

namespace Modules\Platform\Core\Datatable;

use Modules\Platform\Core\Helper\DataTableHelper;
use Yajra\DataTables\EloquentDataTable;

/**
 * Class RelationDataTable
 * @package Modules\Platform\Core\Datatable
 */
abstract class RelationDataTable extends PlatformDataTable
{

    /**
     * @var
     */
    protected $entityId;

    /**
     * @var
     */
    protected $entityClass;

    protected $route;

    public $allowSelect = false;

    public $allowUnlink = false;

    protected $unlinkRoute;

    protected $tableSuffix;

    /**
     * Setup Select Model
     */
    public function selectMode()
    {
        $this->tableSuffix = "_Select";
    }

    public function applyLinks(EloquentDataTable $table, $route, $prefix = null)
    {
        $rawColumns = [];

        foreach ($this->getColumns() as $column => $properties) {
            $rawColumns[] = $column;

            $table->editColumn($column, function ($record) use ($column,$properties,$route,$prefix) {
                if ($properties['data_type'] == 'unlink') {
                    $recordId = $record->id;

                    $view = view('core::crud.relation.unlink');
                    $view->with('entityId', $this->entityId);
                    $view->with('relationEntityId', $recordId);
                    $view->with('unlink_route', $this->unlinkRoute);

                    return $view;
                }

                if ($properties['data_type'] == 'check_select') {
                    $recordId = $record->id;

                    return '<input type="checkbox" name="selection[]" id="'.$prefix.'checkbox_'.$recordId.'" class="call-checkbox filled-in chk-col-blue-grey" value="'.$recordId.'" /><label class="checkbox" for="'.$prefix.'checkbox_'.$recordId.'"></label>';
                }

                return DataTableHelper::renderLink($column, $record, $properties, $route);
            });
        }

        $table->rawColumns($rawColumns);
    }

    /**
     * @param $columnNumber
     * @return mixed
     */
    protected function countFilterColumn($columnNumber)
    {
        if ($this->allowSelect || $this->allowUnlink) {
            return $columnNumber+1;
        }
        return $columnNumber;
    }

    /**
     * @param $entityClass
     * @param $entityId
     * @param $route
     */
    public function setEntityData($entityClass, $entityId, $route)
    {
        $this->entityClass = $entityClass;
        $this->entityId = $entityId;
        $this->route = $route;
    }
}
