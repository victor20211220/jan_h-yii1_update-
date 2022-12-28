<form class="form-horizontal" method="POST">
	<fieldset>
		<legend>
			<?php echo $this -> title ?>
		</legend>

		<?php echo CHtml::errorSummary($form, null, null, array(
			'class' => 'alert alert-danger',
		)); ?>

		<div class="form-group">
		<?php echo CHtml::activeLabel($form, 'login', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($form, 'login', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($form, 'password', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activePasswordField($form, 'password', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($form, 'password2', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activePasswordField($form, 'password2', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($form, 'full_name', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($form, 'full_name', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($form, 'email', array('class' => 'col-lg-2 control-label')); ?>
		<div class="col-lg-10">
		<?php echo CHtml::activeTextField($form, 'email', array('class' => 'form-control')); ?>
		</div>
		</div>

		<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
		<?php echo CHtml::submitButton(Yii::t("site", "Submit"), array(
			'class' => 'btn btn-large btn-primary',
		)); ?>
		</div>
		</div>

	<fieldset>
</form>