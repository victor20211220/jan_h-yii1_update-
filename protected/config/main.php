<?php
$cfg_main = __DIR__.DIRECTORY_SEPARATOR."config.php";
$cfg_local = __DIR__.DIRECTORY_SEPARATOR."config_local.php";
$params = is_file($cfg_local) ? require $cfg_local : require $cfg_main;

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>$params['app.name'],
	'language' => $params['app.default_language'],
    'timeZone' => $params['app.timezone'],
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
        'application.library.*',
		'application.models.*',
		'application.components.*',
		'application.forms.*',
        'application.extensions.ealphabet.EAlphabet',
        'ext.mailer.YiiMailer',
	),

	// application components
	'components'=>array(
	    'fc'=>array(
            'class' => 'application.components.flexible_captcha.FlexibleCaptchaComponent',
            'tmplPath'=>'/flexible_captcha',
        ),
        'authManager' => array(
            'connectionID'=>'db',
            'class'=>'DbAuthManager',
            'assignmentTable' => '{{authassignment}}',
            'itemChildTable' => '{{authitemchild}}',
            'itemTable' => '{{authitem}}',
        ),
		'user'=>array(
			'class'=>'application.components.WebUser',
			'allowAutoLogin'=>true,
			'loginUrl' => array('admin/auth/login'),
            'identityCookie'=>array(
                'httpOnly' => true,
                'path' => $params['app.base_url'],
                'secure'=> $params['cookie.secure'],
                'sameSite'=> $params['cookie.same_site'],
            ),
		),
		'urlManager'=>array(
			'class' => 'UrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>$params['url.show_script_name'],
			'cacheID' => 'cache',
			'rules'=>array(
				'<language:\w{2}>' => 'site/index',
				'<language:\w{2}>/www/<slug:[\\pL\w_-]+>/<id:\d+>' => 'url/index',
				'<language:\w{2}>/banners' => 'site/banners',
				'<language:\w{2}>/contacts' => 'site/contact',
				'<language:\w{2}>/country/<letter:[\\pL]{1}>' => 'country/letters',
				'<language:\w{2}>/country/<country:[\\pL\w\s\-\,\'\(\)\.]+>' => 'country/url',
				'<language:\w{2}>/country/<country:[\\pL\w\s\-\,\'\(\)\.]+>/<page:\d+>' => 'country/url',
				'<language:\w{2}>/category/suggest/<id:\d+>' => 'category/suggest',
				'<language:\w{2}>/search' => 'search/index',
				'<language:\w{2}>/category/captcha' => 'category/captcha',
				'<language:\w{2}>/category/<path:[\\pL\w_\/-]+>/<page:\d+>' => 'category/index',
				'<language:\w{2}>/category/<path:[\\pL\w_\/-]+>' => 'category/index',
                '<language:\w{2}>/category' => 'category/index',
				'<language:\w{2}>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<language:\w{2}>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				'<language:\w{2}>/<controller:\w+>' => '<controller>/index',
				'admin/<language:\w{2}>' => 'admin/site/index',
				'admin' => 'admin/site/index',
				'<module:\w+>/<language:\w{2}>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
				'<module:\w+>/<language:\w{2}>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
				'<module:\w+>/<language:\w{2}>/<controller:\w+>' => '<module>/<controller>/index',
			),
		),
		'db'=>array(
			'connectionString' => "mysql:host={$params['db.host']};dbname={$params['db.dbname']};port={$params['db.port']}",
			'emulatePrepare' => true,
			'username' => $params['db.username'],
			'password' => $params['db.password'],
			'charset' => 'utf8mb4',
			'tablePrefix' => 'directory_',
			//'enableParamLogging' => true,
			//'enableProfiling' => true,
			'schemaCachingDuration' => 60 * 60 * 24 * 30,
		),

		'cache' => array(
			'class' => 'CFileCache',
		),

        'securityManager' => array(
            'encryptionKey'=>$params['app.encryption_key'],
            'validationkey'=>$params['app.validation_key'],
        ),

        'session'=>array(
            'cookieParams'=>array(
                'httponly' => true,
                'path' => $params['app.base_url'],
                'secure'=> $params['cookie.secure'],
                'samesite'=> $params['cookie.same_site'],
            ),
        ),

        'request'=>array(
            'enableCookieValidation'=>$params['app.cookie_validation'],
            'csrfCookie' => array(
                'httpOnly' => true,
                'path' => $params['app.base_url'],
                'secure'=> $params['cookie.secure'],
                'sameSite'=> $params['cookie.same_site'],
            ),
        ),

		'clientScript'=>array(
			'packages'=>array(
				'jquery'=>array(
                    'baseUrl'=>'static/js',
                    'js'=>array('jquery.min.js'),
				),
			),
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

		'themeManager' => array(
			'class' => 'ThemeManager',
			'themes' => array(
				'admin' => 'classic',
				'public' => 'classic',
			),
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				/*array(
					'class'=>'CWebLogRoute',
				),*/
			),
		),
	),

	'params'=>$params,
);