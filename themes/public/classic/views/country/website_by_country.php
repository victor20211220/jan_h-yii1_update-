<script type="text/javascript">
    $(document).ready(function() {
        var urls = {
        <?php foreach($thumbnailStack as $id=>$thumbnail): ?>
        <?php echo $id ?>:<?php echo $thumbnail ?>,
        <?php endforeach; ?>
    };
        dynamicThumbnail(urls);
    });
</script>

<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title"><?php echo CHtml::encode($this->title) ?></h1>
</div>
<div class="panel-body">

<?php if($count > 0 ):
foreach($websites as $website):
$url = $this -> createUrl("url/index", array('slug' => Helper::slug($website -> title), 'id' => $website -> id));
?>
<div class="media">
  <a class="pull-left" href="<?php echo $url ?>">
    <img class="media-object" alt="<?php echo CHtml::encode($website -> title) ?>" width="200px" height="150px" id="thumb_<?php echo $website->id ?>" src="<?php echo Yii::app()->theme->baseUrl ?>/images/loader.gif">
  </a>
  <div class="media-body">
    <h4 class="media-heading"><a href="<?php echo $url ?>"><?php echo $website -> title ?></a></h4>
    <small><?php echo Helper::cropText($website -> url, Yii::app() -> params['params.url_crop_length']) ?></small>
    <br/><br/>
    <p><?php echo Helper::cropText(Helper::mb_ucfirst($website -> description), Yii::app() -> params['params.desc_drop_length']) ?></p>
  </div>
</div>
<?php endforeach; ?>

<?php $this -> widget('CLinkPager', array(
	'pages' => $pages,
	'cssFile' => '',
	'header' => '',
	'hiddenPageCssClass' => 'disabled',
	'selectedPageCssClass' => 'active',
	'htmlOptions' => array(
		'class' => 'pagination pagination-sm',
	)
)); ?>

<?php endif; ?>

</div>
</div>