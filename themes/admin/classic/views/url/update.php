<script type="text/javascript">
var e_template = <?php echo json_encode($e_template); ?>;
$(document).ready(function(){
	$('#email_lang').change(function(){
		var
			lang_id = $(this).val(),
            type_id = $("#Website_type").val(),
			status_id = $("#Website_status").val();
        outputEmail(lang_id, status_id, type_id);
	});

	$('#Website_status').change(function(){
		var
			status_id = $(this).val(),
            type_id = $("#Website_type").val(),
			lang_id = $('#email_lang').val();
        outputEmail(lang_id, status_id, type_id);
	});

    $('#Website_type').change(function(){
        var
            type_id = $(this).val(),
            status_id = $("#Website_status").val(),
            lang_id = $('#email_lang').val();
        outputEmail(lang_id, status_id, type_id);
    });

    function outputEmail(lang_id, status_id, type_id) {
        $("#EmailForm_subject").text(e_template[lang_id][status_id][type_id]['subject']);
        $("#EmailForm_body").text(e_template[lang_id][status_id][type_id]['body']);
    }
});
</script>

<form class="form-horizontal" method="POST">
    <fieldset>
        <legend class="text-break">
            <?php echo $website -> url ?>
        </legend>
        <?php echo CHtml::errorSummary(array($website, $emailForm), null, null, array(
            'class' => 'alert alert-danger',
        )); ?>


        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'url', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeTextField($website, 'url', array(
                    'class' => 'form-control',
                    'value' => $website -> url,
                )); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'title', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeTextField($website, 'title', array(
                    'class' => 'form-control',
                    'value' => $website -> title,
                )); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'description', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeTextArea($website, 'description', array(
                    'class' => 'form-control',
                    'value' => $website -> description,
                    'rows' => 6,
                )); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'lang_id', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeDropDownList($website, 'lang_id', Yii::app() -> params["app.languages"], array('class'=>'form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'country_id', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeDropDownList($website, 'country_id', $country_list, array('prompt' => Yii::t("website", "Select a country"), 'class'=>'form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'type', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeDropDownList($website, 'type', $website -> getTypeList(), array('class' => "form-control")); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo CHtml::activeLabel($website, 'status', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo CHtml::activeDropDownList($website, 'status', $website -> getStatusList(), array('class' => "form-control")); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 control-label">
                <?php echo Yii::t("website", "Full category path") ?>:<br/> <?php echo $website -> category -> formatRootPath(true) ?>
            </label>

            <?php if(Yii::app()->user->checkAccess('admin_category_dropdowncategory')): ?>
            <div class="col-lg-8">
                <?php echo CHtml::activeDropDownList($website, 'category_id',
                    array($website -> category_id => Yii::t("category", "Choose category")) +
                    CHtml::listData(Category::model()->findAll(array('condition'=>'level=1 AND lang_id="'.$website -> lang_id.'"', 'order'=>'lft ASC')), 'id', 'title'),
                    array(
                        'class' => "form-control",
                        'onchange' => '
                            var val = $(this).val();
                            if(val == '. $website -> category_id .') {
                                $("#subcat_0").html("");
                                return false;
                            }
                        '.
                        CHtml::ajax(array(
                                'type'=>'POST',
                                'url'=> $this -> createUrl('admin/category/dropdowncategory'),
                                'data' => array('id' => 'js:$(this).val()'),
                                'update'=> '#subcat_0'
                            )
                        ),
                    )
                );?>
                <div id="subcat_0"></div>
            </div>
            <?php endif; ?>

        </div>

        <label class="checkbox" for="send_email">
            <?php echo Yii::t("website", "Send email when the status has changed") ?>
            <?php echo CHtml::checkBox('send_email', true, array('id' => 'send_email')); ?>
        </label>

        <br/>

        <?php if(Yii::app()->user->checkAccess('admin_url_update')): ?>
        <?php echo CHtml::submitButton(Yii::t("website", "Update"), array('class' => 'btn btn-primary')); ?>
        <?php endif; ?>

        <?php if(Yii::app()->user->checkAccess('admin_url_view')): ?>
        <a href="<?php echo $this -> createUrl("admin/url/view", array("id" => $website -> id)) ?>" class="btn btn-default"><?php echo Yii::t("website", "View") ?></a>
        <?php endif; ?>

        <a href="<?php echo $website -> url ?>" class="btn btn-info" target="_blank"><?php echo Yii::t("website", "Visit link") ?></a>
        <a href="<?php echo $this->createUrl("admin/url/existdofollowlink", array("id"=>$website->id)) ?>" class="btn btn-warning"><?php echo Yii::t("website", "Check do-follow link") ?></a>
    </fieldset>

    <br/>

    <div class="row">
        <div class="col-sm-7 col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo Yii::t("website", "Email template") ?></div>
                <div class="panel-body">

                    <div class="form-group">
                        <?php echo CHtml::label(Yii::t("website", "Template language"), 'email_language', array('class' => 'col-lg-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo CHtml::dropDownList('email_lang', $website -> lang_id, Yii::app() -> params["app.languages"], array('options' => array('id' => 'email_language'), 'class'=>'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::activeLabel($emailForm, 'to', array('class' => 'col-lg-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo CHtml::activeTextField($emailForm, 'to', array(
                                "readonly" => true,
                                "value" => isset($_POST['EmailForm']['to']) ? $_POST['EmailForm']['to'] : $website -> user -> email,
                                'class' => 'form-control'
                            )); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::activeLabel($emailForm, 'subject', array('class' => 'col-lg-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo CHtml::activeTextArea($emailForm, 'subject', array(
                                "value" => isset($_POST['EmailForm']['subject']) ? $_POST['EmailForm']['subject'] : (isset($e_template[$website -> lang_id]) ? $e_template[$website -> lang_id][$website -> status][$website -> type]['subject'] : $e_template[Yii::app()->language][$website -> status][$website -> type]['subject']),
                                "class" => 'form-control',
                                "rows" => 3,
                            )); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::activeLabel($emailForm, 'body', array('class' => 'col-lg-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo CHtml::activeTextArea($emailForm, 'body', array(
                                "value" => isset($_POST['EmailForm']['body']) ? $_POST['EmailForm']['body'] : (isset($e_template[$website -> lang_id]) ? $e_template[$website -> lang_id][$website -> status][$website -> type]['body'] : $e_template[Yii::app()->language][$website -> status][$website -> type]['body']),
                                "class" => 'form-control',
                                "rows" => 6,
                            )); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-sm-5 col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo Yii::t("website", "Sender information") ?></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>
                                    <?php echo $website -> user -> getAttributeLabel("name") ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode($website -> user -> name) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $website -> user -> getAttributeLabel("email") ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode($website -> user -> email) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-break">
                                    <?php echo $website -> user -> getAttributeLabel("comments") ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode($website -> user -> comments) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $website -> user -> getAttributeLabel("ip") ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode($website -> user -> ip) ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>