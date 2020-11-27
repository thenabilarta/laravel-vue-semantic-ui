<?php

namespace Modules\Platform\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Platform\Core\Helper\CrudHelper;
use Modules\Platform\User\Entities\User;

/**
 * Class SettingsSeeder
 */
class UserSeeder extends Seeder
{
    private static $_USERS = [
        [
            'id' => 1,
            'email' => 'admin@laravel-bap.com',
            'is_active' => 1,
            'first_name' => 'Lip',
            'last_name' => 'Gallagher',
            'name' => 'Lip Gallagher',
            'access_to_all_entity' => 1,
            'theme' => 'theme-blue'
        ],
        [
            'id' => 2,
            'email' => 'frank@laravel-bap.com',
            'is_active' => 1,
            'first_name' => 'Frank',
            'last_name' => 'Gallagher',
            'name' => 'Frank Gallagher',
            'access_to_all_entity' => 1,
            'theme' => 'theme-red'
        ]
    ];

    private static $_GROUPS = [
        ['id' => 1, 'name' => 'Marketing Group'],
        ['id' => 2, 'name' => 'Support Group'],
        ['id' => 3, 'name' => 'Service Group']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear();

        $this->addDefault();
    }

    private function clear()
    {
        DB::table('model_has_roles')->truncate();

        DB::table('users')->truncate();

        DB::table('group_user')->truncate();
        DB::table('groups')->truncate();
    }

    private function addDefault()
    {
        foreach (self::$_USERS as $user) {
            $user['password'] = \Illuminate\Support\Facades\Hash::make('admin');
            $user['created_at'] = \Carbon\Carbon::now();
            $user['updated_at'] = \Carbon\Carbon::now();
            DB::table('users')->insert($user);
        }

        User::find(1)->syncRoles(1);
        User::find(2)->syncRoles(1);

        DB::table('groups')->insert(CrudHelper::setDatesInArray(self::$_GROUPS));
    }
}
