<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title"><?php echo CHtml::encode($this -> title) ?></h1>
</div>
<div class="panel-body">

<form class="form-horizontal" method="POST">
	<fieldset>
		<legend><p><?php echo Yii::t("contact", "Contact page text") ?></p></legend>

		<?php echo CHtml::errorSummary($model, null, null, array(
			'class' => 'alert alert-danger',
		)); ?>

		<div class="form-group">
		<?php echo CHtml::activeLabel($model, 'name', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($model, 'name', array('class' => 'form-control')); ?>
		</div>
		</div>


		<div class="form-group">
		<?php echo CHtml::activeLabel($model, 'email', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($model, 'email', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($model, 'subject', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($model, 'subject', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($model, 'body', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextArea($model, 'body', array('class' => 'form-control', 'rows'=>6)); ?>
		</div>
		</div>

		<?php if(Yii::app()->fc->instance()->isAllowed()): ?>
		<div class="form-group">
		<?php echo CHtml::activeLabel($model, 'verifyCode', array('class'=> 'col-lg-2 control-label')); ?>

		<div class="col-lg-10">

        <?php echo Yii::app()->fc->instance()->render(array(
            "model"=>$model,
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


	</fieldset>
</form>

</div>
</div>
