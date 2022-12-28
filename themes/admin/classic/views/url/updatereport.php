<form action="<?php echo $this -> createUrl("admin/url/deletecustomupdate", array('type' => 'delete')) ?>" method="POST">

    <?php $this -> widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
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
                'htmlOptions' => array('style' => 'width: 30px'),
            ),
            array(
                'name' => Yii::t("website", "Website ID"),
                'value' => '$data -> website_id',
                'htmlOptions' => array('style' => 'width: 120px'),
            ),
            array(
                'name' => Yii::t("website", "Url"),
                'value' => '$data -> website != null ? $data -> website -> url : "-"',
            ),
            array(
                'name' => Yii::t("website", "Title"),
                'value' => '$data -> website != null ? $data -> website -> title : "-"',
            ),
            array(
                'name' => Yii::t("website", "Created at"),
                'value' => '$data -> created_at',
            ),

            array(
                'class' => 'CButtonColumn',
                'template'=>'{view}',
                'buttons'=>array(
                    'view'=>array(
                        'label'=>'',
                        'imageUrl'=>false,
                        'visible'=>"Yii::app()->user->checkAccess('admin_url_viewupdate')",
                        'options'=>array('class' => 'grid-button glyphicon glyphicon-eye-open'),
                        'url'=>'Yii::app() -> createUrl("admin/url/viewupdate", array("id" => $data->website_id))',
                    ),
                ),
            ),
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

    <?php if(Yii::app()->user->checkAccess('admin_url_deletecustomupdate')): ?>
    <input class="btn btn-primary" type="submit" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove selected reports?") ?>') ? true : false;" value="<?php echo Yii::t("system_log", "Delete") ?>" />
    <a class="btn btn-default" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove all reports?") ?>') ? true : false;" href="<?php echo $this -> createUrl("admin/url/deletecustomupdate", array("type"=>"truncate")) ?>">
        <?php echo Yii::t("system_log", "Truncate") ?>
    </a>
    <?php endif; ?>

</form>