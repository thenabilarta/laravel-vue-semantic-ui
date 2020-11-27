<?php

namespace Modules\Platform\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Krucas\Settings\Facades\Settings;
use Modules\Platform\Core\Helper\SettingsHelper;

/**
 * Class SettingsSeeder
 */
class DisplaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set(SettingsHelper::S_DISPLAY_SHOW_LOGO_ON_LOGIN, 1);
        Settings::set(SettingsHelper::S_DISPLAY_SHOW_LOGO_IN_APPLICATION, 1);
        Settings::set(SettingsHelper::S_DISPLAY_SHOW_LOGO_IN_PDF, 1);
        Settings::set(SettingsHelper::S_DISPLAY_APPLICATION_NAME, 'Laravel BAP');
        Settings::set(SettingsHelper::S_DISPLAY_LOGIN_BACKGROUND_IMAGE, 'colourful-2691170_1920.jpg');

        Settings::set(SettingsHelper::S_DISPLAY_SIDEBAR_BACKGROUND, 'blue.png');

        Settings::set(SettingsHelper::S_ANNOUNCEMENT_MESSAGE, '');
        Settings::set(SettingsHelper::S_ANNOUNCEMENT_DISPLAY_CLASS, '');

        Settings::set(SettingsHelper::S_DISPLAY_LOGO_UPLOAD, 'storage/files/logo/logo.png');
        Settings::set(SettingsHelper::S_COMPANY_NAME, 'Laravel BAP');
        Settings::set(SettingsHelper::S_COMPANY_ADDRESS_, '4376 Southern Avenue');
        Settings::set(SettingsHelper::S_COMPANY_CITY, 'Ottumwa');
        Settings::set(SettingsHelper::S_COMPANY_STATE, 'Iowa');
        Settings::set(SettingsHelper::S_COMPANY_POSTAL_CODE, '52501');
        Settings::set(SettingsHelper::S_COMPANY_COUNTRY, 'USA');
        Settings::set(SettingsHelper::S_COMPANY_PHONE, '641-455-5847');
        Settings::set(SettingsHelper::S_COMPANY_FAX, '');
        Settings::set(SettingsHelper::S_COMPANY_WEBSITE, 'http://laravel-bap.com');
        Settings::set(SettingsHelper::S_COMPANY_VAT_ID, '');
    }
}
