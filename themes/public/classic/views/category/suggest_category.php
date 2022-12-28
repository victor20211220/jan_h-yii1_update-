<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title"><?php echo Yii::t("website", "Suggest subcategory") ?></h1>
</div>
<div class="panel-body">


<form class="form-horizontal" method="POST">
	<fieldset>
		<legend>
			<ol class="breadcrumb">
				<li>
					<a href="<?php echo rtrim($this -> createUrl("category/index", array("path" => '')), "/") ?>">
							<?php echo Yii::t("category", "Category") ?>
					</a>
				</li>
				<?php foreach($parents = $category -> getParentsLink() as $link): ?>
				<li><a href="<?php echo $link['link'] ?>"><?php echo $link['anchor'] ?></a></li>
				<?php endforeach; ?>
			</ol>
		</legend>

		<?php echo CHtml::errorSummary($suggest, null, null, array(
			'class' => 'alert alert-danger',
		)); ?>

		<div class="form-group">
		<?php echo CHtml::activeLabel($suggest, 'title', array('class' => 'col-lg-3 control-label')); ?>
		<div class="col-lg-9">
		<?php echo CHtml::activeTextField($suggest, 'title', array('class' => 'form-control')); ?>
		<?php echo Yii::t("category", "If approved, category will be created under") ?>
		<strong>
		<?php foreach($parents as $link): ?>
		<?php echo $link['anchor'] ?> &raquo;
		<?php endforeach; ?>
		<?php echo Yii::t("category", "New-cat") ?>
		</strong>
		</div>
		</div>

		<div class="form-group">
		<?php echo CHtml::activeLabel($suggest, 'comments', array('class' => 'col-lg-3 control-label')); ?>
		<div class="col-lg-9">
		<?php echo CHtml::activeTextArea($suggest, 'comments', array('class' => 'form-control', 'rows' => 6)); ?>
		</div>
		</div>

        <?php if(Yii::app()->fc->instance()->isAllowed()): ?>
		<div class="form-group">
		<?php echo CHtml::activeLabel($suggest, 'verifyCode', array('class'=> 'col-lg-3 control-label')); ?>

		<div class="col-lg-9">
            <?php echo Yii::app()->fc->instance()->render(array(
                "model"=>$suggest,
            )); ?>
		</div>

		</div>
		<?php endif; ?>

		<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
		<?php echo CHtml::submitButton(Yii::t("site", "Submit"), array(
			'class' => 'btn btn-large btn-primary',
		)); ?>
		</div>
		</div>

	</fieldset>
</form>

</div>
</div>