<?php

use Illuminate\Database\Seeder;

/**
 * Seed Settings and Modules with dict data & random data
 *
 * Class AllSeeder
 */
class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsSeeder::class);
    }
}
