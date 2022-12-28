<ul class="list-group">
    <?php if(Yii::app()->user->checkAccess('admin_category_suggest')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this->createUrl("admin/category/suggest") ?>">
            <?php echo Yii::t("admin", "Category suggestions") ?>
        </a>
        <span class="badge pull-right"><?php echo Suggest::model() -> count() ?></span>
    </li>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('admin_url_index')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this -> createUrl("admin/url/index", array("type"=>"regularQueue")) ?>">
            <?php echo Yii::t("admin", "URL: Regular queue") ?>
        </a>
        <span class="badge pull-right"><?php echo Website::model()->regularQueue()->count() ?></span>
    </li>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('admin_url_index')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this -> createUrl("admin/url/index", array("type"=>"premiumQueue")) ?>">
            <?php echo Yii::t("admin", "URL: Premium queue") ?>
        </a>
        <span class="badge pull-right"><?php echo Website::model()->premiumQueue()->count() ?></span>
    </li>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('admin_url_brokenlinks')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this -> createUrl("admin/url/brokenlinks") ?>">
            <?php echo Yii::t("admin", "Broken link report") ?>
        </a>
        <span class="badge pull-right"><?php echo BrokenLink::model()->count() ?></span>
    </li>
    <?php endif; ?>

    <?php if(Yii::app()->user->checkAccess('admin_url_updatereport')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this -> createUrl("admin/url/updatereport") ?>">
            <?php echo Yii::t("admin", "URL information update request") ?>
        </a>
        <span class="badge pull-right"><?php echo UpdateUrl::model()->count() ?></span>
    </li>
    <?php endif; ?>
</ul>