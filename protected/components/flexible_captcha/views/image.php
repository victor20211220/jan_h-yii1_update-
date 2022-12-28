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
        'class' => 'btn btn-default',
    ),
    'imageOptions' => array(
        'class' => '',
        'style' => 'float:left;',
    ),
)); ?>

<div class="col-xs-4">
    <?php echo CHtml::activeTextField($model, $attribute, array('class' => 'form-control col-lg-2')); ?>
</div>