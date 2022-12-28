<ul class="list-group">
    <?php if(Yii::app()->user->checkAccess('admin_tools_clearcache')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this->createUrl("admin/tools/clearcache") ?>">
            <?php echo Yii::t("admin", "Clear cache") ?>
        </a>
    </li>
    <?php endif; ?>
    <?php if(Yii::app()->user->checkAccess('admin_tools_generatewebsitecount')): ?>
        <li class="list-group-item">
            <a href="<?php echo $this->createUrl("admin/tools/generatewebsitecount") ?>">
                <?php echo Yii::t("permissions", "admin_tools_generatewebsitecount") ?>
            </a>
        </li>
    <?php endif; ?>
    <?php if(Yii::app()->user->checkAccess('admin_tools_generatesitemap')): ?>
    <li class="list-group-item">
        <a href="<?php echo $this->createUrl("admin/tools/generatesitemap") ?>">
            <?php echo Yii::t("admin", "Generate sitemap") ?>
        </a>
    </li>
    <?php endif; ?>
</ul>