<div class="row">
    <div class="col-xs-6 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo Yii::t("website", "Type constants") ?></div>
            <div class="panel-body">
                <ul>
                    <li>
                        <?php echo Yii::t("website", "Regular") ?> : <?php echo Website::TYPE_REGULAR; ?>
                    </li>
                    <li>
                        <?php echo Yii::t("website", "Premium") ?> : <?php echo Website::TYPE_PREMIUM; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo Yii::t("website", "Status constants") ?></div>
            <div class="panel-body">
                <ul>
                    <li>
                        <?php echo Yii::t("website", "Rejected") ?> : <?php echo Website::STATUS_REJECTED; ?>
                    </li>
                    <li>
                        <?php echo Yii::t("website", "Waiting") ?> : <?php echo Website::STATUS_WAITING; ?>
                    </li>
                    <li>
                        <?php echo Yii::t("website", "Approved") ?> : <?php echo Website::STATUS_APPROVED; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $this -> widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $model->search($scope, $params),
	'filter' => $model,
    'cssFile' => '',
    'itemsCssClass' => 'table table-bordered table-striped table-hover',
    'enableSorting' => false,
    'summaryCssClass' => 'pull-right summary',
    'htmlOptions' => array(
      'class' => 'table-responsive'
    ),
	'columns' => array(
        array(
            'name' => 'id',
            'header' => Yii::t("website", "ID"),
            'value' => '$data -> id',
            'htmlOptions' => array(
                'width' => '10%'
            ),
            'filter' => CHtml::textField('Website[id]', isset($_GET['Website']['id']) ? $_GET['Website']['id'] : '', array(
                'class'=>'form-control'
            )),
        ),
		array(
			'name' => 'category.title',
			'header' => Yii::t("website", "Category name"),
            'value' => 'Category::model() -> cache(60) -> findByPk($data -> category_id) -> formatRootPath(true)',
		),
		array(
            'name' => 'url',
            'value' => '$data->url',
            'htmlOptions' => array(
                'style' => 'word-break: break-word',
            ),
            'filter' => CHtml::textField('Website[url]', isset($_GET['Website']['url']) ? $_GET['Website']['url'] : '', array(
                'class'=>'form-control'
            )),
        ),
		array(
			'name' => 'type',
			'header' => Yii::t("website", "Type"),
			'value' => '$data -> getTypeString()',
            'htmlOptions' => array(
                'width' => '15%'
            ),
            'filter' => CHtml::textField('Website[type]', isset($_GET['Website']['type']) ? $_GET['Website']['type'] : '', array(
                'class'=>'form-control'
            )),
		),
		array(
			'name' => 'status',
			'header' => Yii::t("website", "Status"),
			'value' => '$data -> getStatusString()',
            'htmlOptions' => array(
                'width' => '15%'
            ),
            'filter' => CHtml::textField('Website[status]', isset($_GET['Website']['status']) ? $_GET['Website']['status'] : '', array(
                'class'=>'form-control'
            )),
		),
		array(
			'class' => 'CButtonColumn',
			'template'=>'{view} {update} {delete}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'',
                    'imageUrl'=>false,
                    'visible'=>"Yii::app()->user->checkAccess('admin_url_view')",
                    'options'=>array('class' => 'grid-button glyphicon glyphicon-eye-open'),
                ),
                'update'=>array(
                    'label'=>'',
                    'imageUrl'=>false,
                    'visible'=>"Yii::app()->user->checkAccess('admin_url_update')",
                    'options'=>array('class' => 'grid-button glyphicon glyphicon-edit'),
                ),
                'delete'=>array(
                    'label'=>'',
                    'imageUrl'=>false,
                    'visible'=>"Yii::app()->user->checkAccess('admin_url_delete')",
                    'options'=>array('class' => 'grid-button glyphicon glyphicon-trash'),
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