<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed TLDs - Use with caution!
    |--------------------------------------------------------------------------
    |
    | This is to prevent mis-usage during production if debug mode is
    | unintentionally left active. The package will detect the site
    | URL and if the TLD isn't present in this array, it will not
    | activate. If your development TLD is different to .dev or
    | .local, simply add it to the arrow below.
    |
     */
    /*Sudosu 为了避免开发者在生产环境下误开启此功能，在配置选项 allowed_tlds 里做了域名后缀的限制，
    tld 为 Top Level Domain 的简写。此处因我们的项目域名为 larabbs.test，故将 test 域名后缀添加到 allowed_tlds 数组中。*/
    
    'allowed_tlds' => ['dev', 'local','test'],

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | Path to the application User model. This will be used to retrieve the users
    | displayed in the select dropdown. This must be an Eloquent Model instance.
    |
     */
    
    'user_model' => User::class

];