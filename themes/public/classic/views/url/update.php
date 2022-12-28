<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?php echo $this -> title ?></h1>
    </div>
    <div class="panel-body">


        <form class="form-horizontal" method="POST">
            <fieldset>
                <legend>
                    <?php echo Yii::t("website", "Update Site Info") ?>
                </legend>

                <?php echo CHtml::errorSummary($submit_form, null, null, array(
                    'class' => 'alert alert-danger',
                )); ?>

                <div class="form-group">
                    <label class="col-lg-2 control-label">
                        <?php echo Yii::t("website", "Site Details") ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="form-control fake-input text-break">
                            <a href="<?php echo $url ?>"><?php echo $url ?></a>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">
                        <?php echo Yii::t("website", "Old URL") ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="form-control fake-input">
                            <a href="<?php echo $website -> url ?>"<?php echo !$website -> isPremium() ? ' rel="nofollow"' : null; ?>>
                                <?php echo $website -> url ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'url', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextField($submit_form, 'url', array(
                            'class' => 'form-control',
                            'value' => Helper::_v($post, "url", $website -> url),
                        )); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'title', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextField($submit_form, 'title', array(
                            'class' => 'form-control',
                            'value' => Helper::_v($post, "title", $website -> title),
                        )); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'description', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextArea($submit_form, 'description', array(
                            'class' => 'form-control',
                            'rows' => 6,
                            'value' => Helper::_v($post, "description", $website -> description),
                        )); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'country_id', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php $submit_form -> country_id = (Helper::_v($post, "country_id", false) OR !empty($post)) ? $post["country_id"] : $website -> country_id; ?>
                        <?php echo CHtml::activeDropDownList($submit_form, 'country_id', $country_list, array('prompt' => Yii::t("website", "Select a country"), 'class'=>'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'name', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextField($submit_form, 'name', array(
                            'class' => 'form-control'
                        )); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'email', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextField($submit_form, 'email', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'changes', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextArea($submit_form, 'changes', array('class' => 'form-control', 'rows' => 6)); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($submit_form, 'comments', array('class' => 'col-lg-2 control-label')); ?>
                    <div class="col-lg-10">
                        <?php echo CHtml::activeTextArea($submit_form, 'comments', array('class' => 'form-control', 'rows' => 6)); ?>
                    </div>
                </div>

                <?php if(Yii::app()->fc->instance()->isAllowed()): ?>
                    <div class="form-group">
                        <?php echo CHtml::activeLabel($submit_form, 'verifyCode', array('class'=> 'col-lg-2 control-label')); ?>

                        <div class="col-lg-10">
                            <?php echo Yii::app()->fc->instance()->render(array(
                                "model"=>$submit_form,
                            )); ?>
                        </div>

                    </div>
                <?php endif; ?>


                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <?php echo CHtml::submitButton(Yii::t("site", "Submit"), array(
                            'class' => 'btn btn-large btn-primary',
                        )); ?>
                    </div>
                </div>

                <fieldset>
        </form>

    </div>
</div>