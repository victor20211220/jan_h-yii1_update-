<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?php echo CHtml::encode($this -> title) ?></h1>
    </div>
    <div class="panel-body">
        <p><?php echo Yii::t("site", "Banner text") ?></p><br/>

        <div class="form-group">
            <label class="col-lg-2 control-label"><?php echo Yii::t("site", "Text Link") ?></label>
            <div class="col-lg-10">
                <textarea class="form-control" onclick="this.focus();this.select()" rows="5">
<a href="<?php echo Helper::getBackUrl() ?>" target="_blank">
    <?php echo Yii::t("site", "Website Catalog: PHP8 Developer") ?>

</a></textarea>
            </div>
        </div>
<div class="clearfix"></div><br/>

        <div class="form-group">
            <label class="col-lg-2 control-label"><?php echo Yii::t("site", "Banners") ?></label>
            <div class="col-lg-10">
                <?php foreach($banners as $banner): ?>
                    <img class="img-responsive" src="<?php echo Yii::app()->getBaseUrl() ?>/static/logos/<?php echo $banner ?>"/>
                    <br/>
<textarea class="form-control" onclick="this.focus();this.select()" rows="5">
<a href="<?php echo Helper::getBackUrl() ?>" target="_blank">
    <img src="<?php echo Yii::app()->getBaseUrl(true) ?>/static/logos/<?php echo $banner ?>" alt="<?php echo Yii::t("site", "Website Catalog: PHP8 Developer") ?>" border="0" />
</a></textarea>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
