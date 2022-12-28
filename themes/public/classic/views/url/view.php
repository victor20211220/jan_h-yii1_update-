<script type="text/javascript">
    $(document).ready(function() {
        var related = {
            <?php foreach($relatedThumbnailStack as $id=>$thumbnail): ?>
            <?php echo "related_".$id ?>:<?php echo $thumbnail ?>,
            <?php endforeach; ?>
        };
        var popular = {
        <?php foreach($popularThumbnailStack as $id=>$thumbnail): ?>
            <?php echo "popular_".$id ?>:<?php echo $thumbnail ?>,
            <?php endforeach; ?>
        };

        dynamicThumbnail(related);
        dynamicThumbnail(popular);
        dynamicThumbnail({
        <?php echo "web_".$website->id ?>:<?php echo $thumb ?>,
        });
    });
</script>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?php echo Helper::mb_ucfirst($website -> title); ?></h1>
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
                    <li><a href="<?php echo $link['link'] ?>"><?php echo CHtml::encode($link['anchor']) ?></a></li>
                    <?php endforeach; ?>
                </ol>
            </div>

            <div class="col-xs-12 col-md-4">

                <?php if(!$broken OR !$update): ?>
                <ul class="list-group">

                    <?php if(!$broken): ?>
                    <li class="list-group-item">
                        <small><a href="<?php echo $this -> createUrl("url/brokenlink", array("id" => $website -> id)) ?>"><?php echo Yii::t("website", "Report Broken Link") ?></a></small>
                    </li>
                    <?php endif; ?>

                    <?php if(!$update): ?>
                    <li class="list-group-item">
                        <small><a href="<?php echo $this -> createUrl("url/update", array("id" => $website -> id)) ?>"><?php echo Yii::t("website", "Update Info") ?></a></small>
                    </li>
                    <?php endif; ?>

                </ul>
                <?php endif; ?>

            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th><?php echo Yii::t("website", "Details") ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo Yii::t("website", "Title") ?></td>
                        <td><?php echo Helper::mb_ucfirst($website -> title) ?></td>
                    </tr>
                    <tr>
                        <td><?php echo Yii::t("website", "Url") ?></td>
                        <td>
                            <a href="<?php echo $website -> url ?>"<?php echo !$website -> isPremium() ? ' rel="nofollow"' : null; ?>>
                            <?php echo $website -> url ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo Yii::t("website", "Image") ?></td>
                        <td><img class="media-object img-rounded" alt="<?php echo CHtml::encode($website -> title)?>" id="thumb_web_<?php echo $website->id ?>" src="<?php echo Yii::app()->theme->baseUrl ?>/images/loader.gif">
                    </tr>
                    <tr>
                        <td><?php echo Yii::t("website", "Description") ?></td>
                        <td class="text-break"><?php echo Helper::mb_ucfirst($website -> description) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- //panel body -->
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t("website", "Related Sites") ?></h3>
    </div>

    <div class="panel-body">
        <?php foreach($related as $url):
        $_url = $this -> createUrl("url/index", array('slug' => Helper::slug($url -> title), 'id' => $url -> id));
        ?>
        <div class="media">
            <a class="pull-left" href="<?php echo $_url ?>">
                <img class="media-object" width="90px" height="68px" id="thumb_related_<?php echo $url->id ?>" src="<?php echo Yii::app()->theme->baseUrl ?>/images/loader.gif">
            </a>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="<?php echo $_url?>">
                        <?php echo CHtml::encode($url -> title) ?>
                    </a>
                </h4>
                <p class="text-break"><?php echo Helper::mb_ucfirst(Helper::cropText(CHtml::encode($url -> description), Yii::app() -> params["params.popular_desc_length"])) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t("website", "Popular Sites") ?></h3>
    </div>

    <div class="panel-body">
        <?php foreach($popular as $p):
            $_url = $this -> createUrl("url/index", array('slug' => Helper::slug($p -> title), 'id' => $p -> id));
            ?>
            <div class="media">
                <a class="pull-left" href="<?php echo $_url ?>">
                    <img class="media-object" width="90px" height="68px" id="thumb_popular_<?php echo $p->id ?>" src="<?php echo Yii::app()->theme->baseUrl ?>/images/loader.gif">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="<?php echo $_url?>">
                            <?php echo CHtml::encode($p -> title) ?> <small>(<?php echo Yii::t("website", "Unique hits") ?>: <?php echo (int)$p->statistic->hits ?>)</small>
                        </a>
                    </h4>
                    <p class="text-break"><?php echo Helper::mb_ucfirst(Helper::cropText(CHtml::encode($p -> description), Yii::app() -> params["params.related_desc_length"])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>