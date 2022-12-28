<?php return array(
    'app.name'=>'Web Catalog',
    'app.default_language'=>'en',
    'app.languages' => array(
        'en' => 'English',
        'ru' => 'Русский',
        'de' => 'Deutsch',
        'da' => 'Dansk',
    ),
    'app.timezone'=>'Europe/Berlin', // http://www.php.net/manual/en/timezones.php
    'app.host'=>'http://catalog.codecanyon',
    'app.base_url'=>'/',
    'app.encryption_key'=>'R7KRcQWfQsM3We8LVA0ZLold7kNqJ5VO',
    'app.validation_key'=>'BRmCmfvaemWzz5r5djG7lTkURS2LS0Ku',
    'app.command_key'=>false,
    'app.cookie_validation'=>true,
    'app.captcha'=>true,
    'app.nav_name'=>'',
    'app.nav_icon'=>'',

    // Cookie settings
    'cookie.secure'=>false,
    'cookie.same_site'=>'Lax',

    // Db settings
    'db.host'=>'localhost',
    'db.dbname'=>'telezyvp_catalog',
    'db.username'=>'root',
    'db.password'=>'',
    'db.port'=>3306,

    // Email client settings
    'mailer.host'=>'localhost',
    'mailer.port'=>25,
    'mailer.auth'=>false,
    'mailer.protocol'=>'',
    'mailer.username'=>'',
    'mailer.password'=>'',

    // URL settings
    'url.show_script_name'=>false,

    // Email settings
    'contact.email'=>'',
    'notification.email'=>'',
    'notification.name'=>'Web Catalog',

    // Recaptcha settings
    'recaptcha.public'=>'',
    'recaptcha.private'=>'',
    'recaptcha.theme'=>'light',

    // Cookie Laws settings
    'cookie_law.show'=>true,
    'cookie_law.link'=>'https://www.google.com/intl/{language}/policies/privacy/partners/',
    'cookie_law.theme'=>'light-floating',
    'cookie_law.expiry_days'=>365,

    // Pagepeeker settings
    'thumbnail.proxy'=>false,
    'pagepeeker.verify'=>'',
    'pagepeeker.api_key'=>'',

    // cURL settings
    'curl.cookie_cache_path'=>'application.runtime',
    'curl.user_agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',

    // Template settings
    'template.banner_top'=>'',
    'template.banner_bottom'=>'',
    'template.head'=>'',
    'template.footer'=>'Developed by <strong><a href="http://php8developer.com">PHP 8 Developer</a></strong>',

    // Rest of app params
    'params.desc_drop_length'=>200,
    'params.url_crop_length'=>50,
    'params.url_per_page'=>10,
    'params.admin_url_per_page'=>10,
    'params.search_url_per_page'=>10,
    'params.search_cat_per_page'=>20,
    'params.sub_category_columns'=>4,
    'params.related_website_count'=>10,
    'params.related_desc_length'=>150,
    'params.popular_website_count'=>10,
    'params.popular_desc_length'=>150,
    'params.admin_broken_links'=>10,
    'params.admin_update_links'=>10,
    'params.admin_log'=>25,
    'params.admin_suggest'=>10,
    'params.top_listing'=>20,
    'params.top_listing_columns'=>2,
    'params.new_listing'=>20,
    'params.new_listing_columns'=>2,
    'params.roots_columns'=>2,
    'params.country_columns'=>2,
    'params.country_url_per_page'=>10,
    'params.admin_bad_login_count'=>3,
    'params.url_search_min_length'=>3,
    'params.cat_search_min_length'=>2,
    'params.cat_cache_time'=>3600*5, // 5 hours
    'params.premium_backlink_attempts'=>2,
    'params.admin_enable_action_logging'=>true,
    'params.back_url'=>false,
);
