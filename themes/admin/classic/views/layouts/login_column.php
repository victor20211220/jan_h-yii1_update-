<?php $this -> beginContent('//layouts/main'); ?>

<div class="container">
<?php echo $this -> renderPartial("//site/flash") ?>
<?php echo $content ?>
</div>

<?php $this -> endContent(); ?>