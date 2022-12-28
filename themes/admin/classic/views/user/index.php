<div class="row">
    <div class="col-xs-6 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo Yii::t("user", "Status") ?></div>
            <div class="panel-body">
                <ul>
                    <li>
                        <?php echo Yii::t("user", "Active") ?> : <?php echo User::STATUS_ACTIVE ?>
                    </li>
                    <li>
                        <?php echo Yii::t("user", "Blocked") ?> : <?php echo User::STATUS_BLOCK ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=> $user -> search(),
    'filter' => $user,
    'cssFile' => '',
    'itemsCssClass' => 'table table-bordered table-striped table-hover',
    'enableSorting' => false,
    'summaryCssClass' => 'pull-right summary',
    'htmlOptions' => array(
        'class' => 'table-responsive'
    ),
    'rowCssClassExpression' => '$data->isBlocked() ? "warning" : null',
    'columns' => array(
        array(
            'name' => 'id',
            'header' => Yii::t("website", "ID"),
            'value' => '$data -> id',
            'htmlOptions' => array(
                'width' => '10%'
            ),
            'filter' => CHtml::textField('User[id]', isset($_GET['User']['id']) ? $_GET['User']['id'] : '', array(
                'class'=>'form-control'
            )),
        ),
        array(
            'name' => 'login',
            'header' => Yii::t("user", "Login"),
            'value' => '$data->login',
            'filter' => CHtml::textField('User[login]', isset($_GET['User']['login']) ? $_GET['User']['login'] : '', array(
                'class'=>'form-control',
            ))
        ),
        array(
            'name' => 'full_name',
            'header' => Yii::t("user", "Full Name"),
            'value' => '$data->profile->full_name',
            'filter' => CHtml::textField('User[search_full_name]', isset($_GET['User']['search_full_name']) ? $_GET['User']['search_full_name'] : '', array(
                'class'=>'form-control',
            ))
        ),
        array(
            'name' => 'email',
            'header' => Yii::t("user", "Email"),
            'value' => '$data->profile->email',
            'filter' => CHtml::textField('User[search_email]', isset($_GET['User']['search_email']) ? $_GET['User']['search_email'] : '', array(
                'class'=>'form-control',
            ))
        ),
        array(
            'name' => 'created_at',
            'header' => Yii::t("website", "Created at"),
            'value' => '$data->created_at',
            'filter' => CHtml::textField('User[created_at]', isset($_GET['User']['created_at']) ? $_GET['User']['created_at'] : '', array(
                'class'=>'form-control',
            ))
        ),
        array(
            'name' => 'status',
            'header' => Yii::t("user", "Status"),
            'value' => '$data->isBlocked() ? Yii::t("user", "Blocked") : Yii::t("user", "Active")',
            'filter' => CHtml::textField('User[status]', isset($_GET['User']['status']) ? $_GET['User']['status'] : '', array(
                'class'=>'form-control',
            ))

        ),
        array(
            'class' => 'CButtonColumn',
            'htmlOptions' => array(
                'width'=>'60px'
            ),
            'template'=>'{view} {update} {delete}',

            'viewButtonImageUrl' => false,
            'viewButtonLabel' =>'',
            'viewButtonOptions' => array('class' => 'grid-button-inline glyphicon glyphicon-eye-open'),

            'deleteButtonImageUrl' => false,
            'deleteButtonLabel' =>'',
            'deleteButtonOptions' => array('class' => 'grid-button-inline glyphicon glyphicon-trash'),

            'updateButtonImageUrl' => false,
            'updateButtonLabel' => '',
            'updateButtonOptions' => array('class' => 'grid-button-inline glyphicon glyphicon-edit')
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