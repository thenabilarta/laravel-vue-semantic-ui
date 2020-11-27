<?php

namespace Modules\Platform\Core\Helper;

use Modules\Platform\Core\Http\Controllers\ModuleCrudController;
use Modules\Platform\User\Entities\Group;
use Modules\Platform\User\Entities\User;

/**
 * Class FormHelper
 * @package Modules\Platform\Core\Helper
 */
class FormHelper
{
    /**
     * Assign Selected User or Group from Object Model
     * @param $model
     * @return string
     */
    public static function assignSelectedFromModel($model)
    {
        if ($model != null && isset($model->owner) != null) {
            if ($model->owner instanceof User) {
                return 'user-' . $model->owner->id;
            } else {
                return 'group-' . $model->owner->id;
            }
        }
    }

    /**
     * Convert entity to choises
     * @param $entityList
     * @param $fieldName
     * @return array
     */
    public static function entityToChoises($entityList, $fieldName)
    {
        $result = [];

        foreach ($entityList as $e) {
            $result[$e->id] = $e->{$fieldName};
        }

        return $result;
    }

    public static function calendarDefaultView()
    {
        $options = [
            'month' => trans('core::core.dict.month'),
            'agendaWeek' => trans('core::core.dict.basic_week'),
            'agendaDay' => trans('core::core.dict.basic_day'),

        ];

        return $options;
    }

    /**
     * Calendar first day
     * @return array
     */
    public static function calendarFirstDay()
    {
        $options = [
            1 => trans('core::core.dict.monday'),
            0 => trans('core::core.dict.sunday')
        ];
        return $options;
    }

    /**
     * @return array
     */
    public static function calendarDayStartsAt()
    {
        $options = [];

        for ($i = 1; $i <= 9; $i++) {
            $options['0' . $i . ':00:00'] = '0' . $i . ':00:00';
        }

        return $options;
    }

    /**
     * Return Array of users and groups
     * @return array
     */
    public static function assignedToChoises()
    {
        $options = [
            trans('core::core.form.optgroup.users') => User::all()->mapWithKeys(function ($item) {
                return ['user-' . $item['id'] => $item['name']];
            })->toArray(),
            trans('core::core.form.optgroup.groups') => Group::all()->mapWithKeys(function ($item) {
                return ['group-' . $item['id'] => $item['name']];
            })->toArray(),
        ];

        return $options;
    }
}
