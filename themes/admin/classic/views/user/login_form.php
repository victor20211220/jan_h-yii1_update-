<form class="form-signin" method="post">
	<h2 class="form-signin-heading"><?php echo Yii::t("admin", "Please sign in") ?></h2>

    <?php echo CHtml::errorSummary($model, null, null, array(
        'class' => 'alert alert-danger',
    )); ?>

	<?php echo CHtml::activeTextField($model, 'login', array(
		'class' => 'form-control login',
		'placeholder' => 'login',
		'required' => true,
		'autofocus' => true,
	));?>

	<?php echo CHtml::activePasswordField($model, 'password', array(
		'class' => 'form-control password',
		'placeholder' => 'password',
		'required' => true,
	));?>

    <?php echo Yii::app()->fc->instance()->render(array(
        "model"=>$model,
    ),  "admin_login"); ?>


	<label class="checkbox" for="LoginForm_remember_me">
		<?php echo CHtml::activeCheckBox($model, 'remember_me'); ?> <?php echo Yii::t("user", "Rember me"); ?>
	</label>

	<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo Yii::t("user", "Sign in") ?></button>
</form>