<?php if(Yii::app()->user->allowedGroup('admin_category')): ?>
<div class="col-xs-12 col-sm-12 fix-inner-padding">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo Yii::t("category", "Category") ?>
            </h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <?php if(Yii::app()->user->checkAccess('admin_category_roots')): ?>
                <li  class="<?php echo $this->getId() == "admin/category" && in_array($this->action->Id, array("roots", "manage")) ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/category/roots") ?>">
                        <?php echo Yii::t("category", "Manage roots") ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(Yii::app()->user->checkAccess('admin_category_suggest')): ?>
                <li class="<?php echo $this->getId() == "admin/category" && $this->action->Id == "suggest" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/category/suggest") ?>">

                        <?php echo Yii::t("category", "Suggestions") ?>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->allowedGroup('admin_url')): ?>
<div class="col-xs-12 col-sm-12 fix-inner-padding">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("site", "URLs") ?></h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <?php if(Yii::app()->user->checkAccess('admin_url_index')): ?>
                <li class="<?php echo $this->getId() == "admin/url" && $this->action->Id == "index" && Yii::app()->request->getQuery('type') == 'regularQueue' ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/url/index", array("type"=>"regularQueue")) ?>">
                        <?php echo Yii::t("website", "Regular queue") ?>
                    </a>
                </li>
                <li class="<?php echo $this->getId() == "admin/url" && $this->action->Id == "index" && Yii::app()->request->getQuery('type') == 'premiumQueue' ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/url/index", array("type"=>"premiumQueue")) ?>">
                        <?php echo Yii::t("website", "Premium queue") ?>
                    </a>
                </li>
                <li class="<?php echo $this->getId() == "admin/url" && !in_array($this->action->Id, array("brokenlinks", "updatereport")) && !isset($_GET['type']) ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/url/index") ?>">
                        <?php echo Yii::t("website", "Manage URLs") ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(Yii::app()->user->checkAccess('admin_url_brokenlinks')): ?>
                <li class="<?php echo $this->getId() == "admin/url" && $this->action->Id == "brokenlinks" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/url/brokenlinks") ?>">
                        <?php echo Yii::t("website", "Broken links") ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(Yii::app()->user->checkAccess('admin_url_updatereport')): ?>
                <li class="<?php echo $this->getId() == "admin/url" && $this->action->Id == "updatereport" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/url/updatereport") ?>">
                        <?php echo Yii::t("website", "Update reports") ?>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->checkAccess('admin_tools_index')): ?>
<div class="col-xs-12 col-sm-12 fix-inner-padding">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("admin", "Tools") ?></h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php echo $this->getId() == "admin/tools" && $this->action->Id == "index" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/tools/index") ?>">
                        <?php echo Yii::t("admin", "Tools") ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->isSuperUser()): ?>
<div class="col-xs-12 col-sm-12 fix-inner-padding">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("site", "Users") ?></h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php echo $this->getId() == "admin/user" && $this->action->Id != "create" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/user/index") ?>">
                        <?php echo Yii::t("user", "Users") ?>
                    </a>
                </li>
                <li class="<?php echo $this->getId() == "admin/user" && $this->action->Id == "create" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/user/create") ?>">
                        <?php echo Yii::t("user", "Create User") ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12 fix-inner-padding">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("system_log", "System log") ?></h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li class="<?php echo $this->getId() == "admin/systemlog" && $this->action->Id == "index" ? "active" : null ?>">
                    <a href="<?php echo $this -> createUrl("admin/systemlog/index") ?>">
                        <?php echo Yii::t("system_log", "Log") ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>