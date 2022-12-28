<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        // console application components
        'components'=>array(
            'user'=>array(
                'class'=>'application.components.ConsoleUser',
            ),
            'request' => array(
                'hostInfo' => $params['app.host'],
                'baseUrl' => rtrim($params['app.base_url'], "/"),
                'scriptUrl'=>rtrim($params['app.base_url'], "/").'/index.php',
            ),
        ),
    )
);