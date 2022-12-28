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


<?php foreach($results as $result):?>
<?php $url = $this -> createUrl("url/index", array('slug' => Helper::slug($result -> title), 'id' => $result -> id)); ?>
<div class="media">
  <a class="pull-left" href="<?php echo $url ?>">
    <img class="media-object" alt="<?php echo CHtml::encode($result -> title) ?>" width="200px" height="150px" id="thumb_<?php echo $result->id ?>" src="<?php echo Yii::app()->theme->baseUrl ?>/images/loader.gif">
  </a>
  <div class="media-body">
    <h4 class="media-heading"><a href="<?php echo $url ?>"><?php echo $result -> title ?></a></h4>
    <small><?php echo Helper::cropText($result -> url, Yii::app() -> params['params.url_crop_length']) ?></small>
    <br/><br/>
    <p><?php echo Helper::cropText(Helper::mb_ucfirst($result -> description), Yii::app() -> params['params.desc_drop_length']) ?></p>
  </div>
</div>

<?php endforeach; ?>
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