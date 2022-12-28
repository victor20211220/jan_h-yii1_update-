<?php
/**
 * @var $params array
 * @var $model CModel
 * @var $attribute string
 */

$this->widget('ReCaptcha2Widget', array(
    "siteKey"=>$params['conf']['public-key'],
    'model'=>$model,
    'attribute'=>$attribute,
    "wrapperOptions"=>array(
        'class'=>'recaptcha_wrapper'
    ),
    "widgetOpts"=>array(
        "theme"=>$params['conf']['theme'],
    )
));