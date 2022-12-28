<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title"><?php echo CHtml::encode($this->title) ?></h1>
</div>
<div class="panel-body">

<center>
<div class="btn-toolbar" role="toolbar">
	<?php foreach($letters as $l): ?>
		<a class="btn color-white btn-xs btn-<?php echo mb_strtolower($l) == $letter ? "primary" : "default" ?>" href="<?php echo $this->createUrl("country/letters", array("letter"=>$l)) ?>">
			<?php echo CHtml::encode($l) ?>
		</a>
	<?php endforeach; ?>
</div>
</center>

<br/>

<div class="table-responsive">
	<table class="table">
		<tr>
		<?php $i=0; foreach($countries as $country_id => $country): ?>
		<td width="<?php echo round(100 / Yii::app() -> params["params.country_columns"]) ?>%">
			<a href="<?php echo $this -> createUrl("country/url", array("country"=>$country)) ?>">
				<?php echo CHtml::encode($country) ?>
				<?php if(isset($statistic[strtoupper($country_id)])): ?>
				&nbsp;<span class="badge"><?php echo (int) $statistic[strtoupper($country_id)] ?></span>
				<?php endif; ?>
			</a>
			</td>
		<?php if(($i + 1) % Yii::app() -> params["params.country_columns"] == 0) :?></tr><tr><?php endif; ?>
		<?php $i++; endforeach; ?>
		</tr>
	</table>
</div>


</div>
</div>