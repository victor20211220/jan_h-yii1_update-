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
<h1 class="panel-title"><?php echo $category -> title; ?></h1>
</div>

<div class="panel-body">
<!-- panel body -->

<div class="row">
	<div class="col-xs-12 col-md-8">
		<ol class="breadcrumb">
			<li class="active">
				<a href="<?php echo rtrim($this -> createUrl("category/index", array("path" => '')), "/") ?>">
                    <?php echo Yii::t("category", "Category") ?>
				</a>
			</li>
			<?php foreach($category -> getParentsLink() as $link): ?>
			<?php if(!$link['last']): ?>
			<li><a href="<?php echo $link['link'] ?>"><?php echo CHtml::encode($link['anchor']) ?></a></li>
			<?php else: ?>
			<li class="active"><?php echo $link['anchor'] ?></li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ol>
	</div>

	<div class="col-xs-12 col-md-4">
        <ul class="list-group">
            <li class="list-group-item">
                <small><a href="<?php echo $this -> createUrl("url/submit", array("id" => $category -> id)) ?>"><?php echo Yii::t("category", "Submit a website") ?></a></small>
            </li>
            <li class="list-group-item">
                <small><a href="<?php echo $this -> createUrl("category/suggest", array("id" => $category -> id)) ?>"><?php echo Yii::t("category", "Suggest subcategory") ?></a></small>
            </li>
            <li class="list-group-item">
                <small><a href="<?php echo $this -> createUrl("search/category") ?>"><?php echo Yii::t("category", "Search Category") ?></a></small>
            </li>
        </ul>
	</div>
</div>


<?php if(!empty($children)) : ?>

<h4><?php echo Yii::t("category", "Subcategories") ?></h4>

<div class="table-responsive">
	<table class="table">
		<tr>
		<?php foreach($children as $i => $child): ?>
		<td width="<?php echo round(100 / Yii::app() -> params["params.sub_category_columns"]) ?>%">
            <a href="<?php echo $this -> createUrl("category/index", array("path" => $path. '/'. $child -> slug)) ?>">
                <?php if(isset($statistic[$child->id])): ?>
                    <span class="badge pull-right"><?php echo $statistic[$child->id] ?></span>
                <?php endif; ?>
                <?php echo CHtml::encode($child -> title) ?>
            </a>
        </td>
		<?php if(($i + 1) % Yii::app() -> params["params.sub_category_columns"] == 0) :?></tr><tr><?php endif; ?>
		<?php endforeach; ?>
		</tr>
	</table>
</div>
<?php endif; ?>

<?php if($count > 0 ): ?>
<h2><?php echo Yii::t("website", "Websites") ?></h2>
<?php
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
    <p class="text-break"><?php echo Helper::cropText(Helper::mb_ucfirst($website -> description), Yii::app() -> params['params.desc_drop_length']) ?></p>
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

<!-- //panel body -->
</div>
</div>


