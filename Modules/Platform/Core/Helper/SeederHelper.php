<?php

namespace Modules\Platform\Core\Helper;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder Helper save or update data in table fill created at and updated at
 *
 * Class SeederHelper
 * @package Modules\Platform\Core\Helper
 */
class SeederHelper extends Seeder
{

    /**
     * Save or update database records
     *
     * @param $table
     * @param $attributes
     */
    public function saveOrUpdate($table, $attributes)
    {
        foreach ($attributes as $attr) {
            $record = \DB::table($table)->find($attr['id']);

            if ($record != null) {
                $attr['updated_at'] = Carbon::now();
                if ($record->created_at == null) {
                    $attr['created_at'] = Carbon::now();
                }

                \DB::table($table)->updateOrInsert(['id' => $attr['id']], $attr);
            } else {
                $attr['created_at'] = Carbon::now();

                \DB::table($table)->updateOrInsert(['id' => $attr['id']], $attr);
            }
        }
    }
}
