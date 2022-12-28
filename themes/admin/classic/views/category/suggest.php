<form action="<?php echo $this -> createUrl("admin/category/deletesuggest", array("type"=>"remove")) ?>" method="POST">

<?php $this -> widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $dataProvider,
    'cssFile' => '',
    'itemsCssClass' => 'table table-bordered table-striped table-hover',
    'enableSorting' => false,
    'summaryCssClass' => 'pull-right summary',
	'columns' => array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 2,
			'checkBoxHtmlOptions' => array('class' => 'classname', 'name' => 'ids[]'),
		), 
		'id',
		array(
			'name' => 'title',
			'value' => 'Category::model() -> findByPk($data -> category_id) -> formatRootPath(true) . " / ". $data -> title',
		),
		array(
			'name' => 'comments',
		),
		'created_at',
        'ip'
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

<?php if(Yii::app()->user->checkAccess('admin_category_deletesuggest')): ?>

<input class="btn btn-primary" type="submit" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove selected suggestions?") ?>') ? true : false;" value="<?php echo Yii::t("system_log", "Delete") ?>" />
<a class="btn btn-default" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove all suggestions?") ?>') ? true : false;" href="<?php echo $this -> createUrl("admin/category/deletesuggest", array("type"=>"truncate")) ?>">
<?php echo Yii::t("system_log", "Truncate") ?>
</a>

<?php endif; ?>


</form>