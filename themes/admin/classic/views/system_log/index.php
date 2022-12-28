<form action="<?php echo $this -> createUrl("admin/systemlog/remove", array("type" => "delete")) ?>" method="POST">

<?php $this -> widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $provider,
	//'filter' => $model,
    'cssFile' => '',
    'itemsCssClass' => 'table table-bordered table-striped table-hover',
    'enableSorting' => false,
    'summaryCssClass' => 'pull-right summary',
    'htmlOptions' => array(
        'class' => 'table-responsive'
    ),
	'columns' => array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 2,
			'checkBoxHtmlOptions' => array('class' => 'classname', 'name' => 'ids[]'),
		), 
		'id',
		array(
			'name' => 'user_id',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data -> profile -> full_name),  Yii::app()->controller->createUrl("admin/user/view", array("id" => $data ->user_id)), array("target" => "_blank"))',
		),
		array(
			'name' => 'module',
			'value' => 'Yii::t("system_log", $data -> module)',
		),
		array(
			'name' => 'log',
			'type' => 'html',
			'value' => 'Yii::t("system_log", $data -> log, unserialize($data -> params))',
		),
		'created_at',
	),
    'pagerCssClass' => 'pull-right',
    'pager' => array(
        'cssFile' => '',
        'header' => '',
        'hiddenPageCssClass' => 'disabled',
        'selectedPageCssClass' => 'active',
        'htmlOptions' => array(
            'class' => 'pagination pagination-sm',
        )
    )
)); ?>

<input class="btn btn-primary" type="submit" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove selected logs?") ?>') ? true : false;" value="<?php echo Yii::t("system_log", "Delete") ?>" />
<a class="btn btn-default" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove all system logs?") ?>') ? true : false;" href="<?php echo $this -> createUrl("admin/systemlog/remove", array("type" => "truncate")) ?>">
    <?php echo Yii::t("system_log", "Truncate") ?>
</a>

</form>