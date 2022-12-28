<h3><?php echo Yii::t("category", "Category List Matched") ?></h3>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
			<?php foreach($results as $category): ?>
				<ol class="breadcrumb">
					<?php foreach($category->getParentsLink() as $link): ?>
						<li><a href="<?php echo $link['link'] ?>"><?php echo CHtml::encode($link['anchor']) ?></a></li>
					<?php endforeach; ?>
				</ol>
			<?php endforeach; ?>
	</div>
</div>

<?php $this->widget('CLinkPager', array(
	'pages' => $pages,
	'cssFile' => '',
	'header' => '',
	'hiddenPageCssClass' => 'disabled',
	'selectedPageCssClass' => 'active',
	'htmlOptions' => array(
		'class' => 'pagination pagination-sm',
	)
)); ?>