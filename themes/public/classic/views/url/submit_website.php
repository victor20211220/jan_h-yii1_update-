<script type="text/javascript">
$(document).ready(function(){
    if($('input[class=type_choice]:checked', '.form-horizontal').val() == <?php echo Website::TYPE_PREMIUM ?>) {
        $(".backlink").each(function(){
            $(this).show();
        })
    }

    $(".type_choice").change(function() {
        var show = $(this).val() == <?php echo Website::TYPE_PREMIUM ?> ? true : false;
        $(".backlink").each(function(){
            show ? $(this).show() : $(this).hide();
        })
    });
})
</script>
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title"><?php echo Yii::t("website", "Submit website") ?></h1>
</div>
<div class="panel-body">


<form class="form-horizontal" method="POST">
	<fieldset>
		<legend>
			<?php echo Yii::t("website", "Add website into following category") ?> :
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo rtrim($this -> createUrl("category/index", array("path" => '')), "/") ?>">
						<?php echo Yii::t("category", "Category") ?>
					</a>
				</li>
				<?php foreach($category -> getParentsLink() as $link): ?>
				<li><a href="<?php echo $link['link'] ?>"><?php echo $link['anchor'] ?></a></li>
				<?php endforeach; ?>
			</ol>
		</legend>

		<?php echo CHtml::errorSummary($submit_form, null, null, array(
			'class' => 'alert alert-danger',
		)); ?>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'type', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">

		<?php echo CHtml::activeRadioButtonList($submit_form, 'type', array(
            Website::TYPE_REGULAR => Yii::t("website", "Free Listing").  '<br><small>'. Yii::t("website", "Regular text").'</small>',
            Website::TYPE_PREMIUM => Yii::t("website", "Premium Listing"). '<br><small>'. Yii::t("website", "Premium text", array(
				"{Cost}" => Yii::app() -> params["linkCost"],
			)).'</small>',
		), array(
            'class'=>'type_choice',
        )); ?>
		</div>

		</div>

        <div class="form-group backlink">
            <label class="col-lg-2 control-label"><?php echo Yii::t("site", "Text Link") ?></label>
            <div class="col-lg-10">
                <textarea class="form-control" onclick="this.focus();this.select()" rows="5">
<a href="<?php echo Helper::getBackUrl() ?>" target="_blank">
    <?php echo Yii::t("site", "Website Catalog: PHP8 Developer") ?>

</a></textarea>
            </div>
        </div>
        <div class="form-group backlink">
            <label class="col-lg-2 control-label"><?php echo Yii::t("site", "Banners") ?></label>
            <div class="col-lg-10">
                <?php foreach($banners as $banner): ?>
                    <img class="img-responsive" src="<?php echo Yii::app()->getBaseUrl() ?>/static/logos/<?php echo $banner ?>"/>
                    <br/>
                    <textarea class="form-control" onclick="this.focus();this.select()" rows="5">
<a href="<?php echo Helper::getBackUrl() ?>" target="_blank">
    <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/banners/<?php echo $banner ?>" alt="<?php echo Yii::t("site", "Website Catalog: PHP8 Developer") ?>" border="0" />
</a></textarea>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'url', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($submit_form, 'url', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'title', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($submit_form, 'title', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'description', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextArea($submit_form, 'description', array('class' => 'form-control', 'rows' => 6)); ?>
        <span class="help-block"><?php echo Yii::t("website", "Description help text") ?></span>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'country_id', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeDropDownList($submit_form, 'country_id', $country_list, array('prompt' => Yii::t("website", "Select a country"), 'class'=>'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'name', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($submit_form, 'name', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'email', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($submit_form, 'email', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($submit_form, 'comments', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextArea($submit_form, 'comments', array('class' => 'form-control', 'rows' => 6)); ?>
		</div>
		</div>

        <?php if(Yii::app()->fc->instance()->isAllowed()): ?>
		<div class="form-group ">
		<?php echo CHtml::activeLabel($submit_form, 'verifyCode', array('class'=> 'col-lg-2 control-label')); ?>

		<div class="col-lg-10">
            <?php echo Yii::app()->fc->instance()->render(array(
                "model"=>$submit_form,
            )); ?>
		</div>

		</div>
		<?php endif; ?>

        <?php echo CHtml::activeHiddenField($submit_form, 'category_id', array('value' => $category -> id)) ?>
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