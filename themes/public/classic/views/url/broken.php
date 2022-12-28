<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?php echo Yii::t("website", "Report Broken Link or Site Error") ?></h1>
    </div>

    <div class="panel-body">
        <?php echo CHtml::errorSummary($model, null, null, array(
            'class' => 'alert alert-danger',
        )); ?>
        <form class="form-horizontal" method="POST">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th width="20%"><?php echo Yii::t("website", "Details") ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo Yii::t("website", "Site Details") ?></td>
                    <td><?php echo $this -> createAbsoluteUrl("url/index", array('slug' => Helper::slug($website -> title), 'id' => $website -> id)) ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t("website", "Url") ?></td>
                    <td><?php echo $website -> url ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t("website", "Title") ?></td>
                    <td><?php echo Helper::mb_ucfirst($website -> title) ?></td>
                </tr>
                <tr>
                    <td>
                        <?php echo Yii::t("website", "Description") ?>
                    </td>
                    <td>
                        <p class="text-break">
                            <?php echo Helper::mb_ucfirst($website -> description) ?>
                        </p>
                    </td>
                </tr>
                <?php if(Yii::app()->fc->instance()->isAllowed()): ?>
                <tr>
                    <td><?php echo CHtml::activeLabel($model, 'verifyCode', array('class'=> 'control-label')); ?></td>
                    <td>
                        <div class="col-lg-10 fix-padding-left">
                            <?php echo Yii::app()->fc->instance()->render(array(
                                "model"=>$model,
                            )); ?>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td>

                    </td>
                    <td>
                        <?php echo CHtml::submitButton(Yii::t("site", "Submit"), array(
                            'class' => 'btn btn-large btn-primary',
                        )); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php echo CHtml::activeHiddenField($model, 'website_id', array('value' => $website -> id)); ?>
        </form>
    </div>
</div>