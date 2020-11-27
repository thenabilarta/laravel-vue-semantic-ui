<?php

return [

    /*
    |--------------------------------------------------------------------------
    | laravel-bap.com - global settings
    |--------------------------------------------------------------------------

    */

    'version' => env('APP_VERSION', '1.01'),

    'allow_registration' => env('BAP_ALLOW_REGISTRATION', false),

    /*
     * Attachments module validation
     */
    'file_upload_types' => 'jpe?g|png|pdf|zip|rar|doc?x',
    'file_upload_laravel_validation' => 'jpg,jpeg,png,pdf,zip,rar,doc,docx',
    'allowe_file_types_message' => 'Jpg, Jpeg, Png, Pdf, Zip, Rar, Doc, Docx',

    /*
     * because soft delete does not check foreign keys,
     * we added a special validation when deleting records. Note that foreign keys must be defined in the database
     * Validation is added In SettingsCrudController, ModuleCrudController
     * Example: (when deleting Language with id 1,  all users with language_id = 1 will be broken and view won't work)
     */
    'validate_fk_on_soft_delete' => true,

    /*
     * XSS Protection Middleware
     */
    'xss_protection_available_html_tags' => '<p><b><strike><blockquote><h1><h2><h3><h4><sup><sub><br><strong><i>',

    /*
     * Google analytics
     */
    'google_ga' => env('GOOGLE_GA', ''),

    'global_search' => false, // Not working yet

    /*
     * Demo instance configuration
     */
    'install_demo_data' => env('BAP_INSTALL_DEMO_DATA', false),
    'demo' => env('BAP_DEMO', false),
    'demo_data_seed' => 200,
    'demo_login' => 'admin@laravel-bap.com',
    'demo_pass' => 'admin',

    /**
     * Set to true if only BAP Platform is installed
     * Set to false if BAP CRM is installed
     */
    'clean_platform' => env('CLEAN_BAP_PLATFORM', false),

    /**
     * Notifications
     */
    'comment_notification_enabled' => env('BAP_COMMENT_NOTIFICATION_ENABLED', true),
    'attachment_notification_enabled' => env('BAP_ATTACHMENT_NOTIFICATION_ENABLED', true),
    'record_assigned_notification_enabled' => env('BAP_RECORD_ASSIGNED_NOTIFICATION_ENABLED', true),
];
