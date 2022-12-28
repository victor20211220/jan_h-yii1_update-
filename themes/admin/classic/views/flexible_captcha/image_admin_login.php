<?php
/**
 * @var $params array
 * @var $model CModel
 * @var $attribute string
 */
?>
<?php $this->widget('CCaptcha', array(
    'buttonType' => 'button',
    'buttonOptions' => array(
        'class' => 'btn btn-success refresh-button',
    ),
    'imageOptions' => array(
        'class'=>'captcha_img'
    ),
)); ?>
<?php echo CHtml::activeTextField($model, $attribute, array(
    'class' => 'form-control captcha',
    'placeholder' => Yii::t("app", "CAPTCHA"),
)); ?>