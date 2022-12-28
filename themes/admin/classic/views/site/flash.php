<?php foreach(Yii::app() -> user -> getFlashes() as $key => $message): ?>
<div class="alert alert-<?php echo $key ?>">
<?php echo $message ?>
<button type="button" class="close" data-dismiss="alert">×</button>
</div>
<?php endforeach; ?>