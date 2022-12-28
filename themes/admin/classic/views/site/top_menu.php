<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo $this -> createUrl("admin/site/index") ?>"><?php echo Yii::t("admin", "Admin Panel") ?></a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">

        <?php if(Yii::app()->user->allowedGroup('admin_category')): ?>
        <li class="dropdown <?php echo $this->getId() == "admin/category" ? "active" : null ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;
                <?php echo Yii::t("category", "Category") ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <?php if(Yii::app()->user->checkAccess('admin_category_roots')): ?>
                <li class="<?php echo $this->getId() == "admin/category" && in_array($this->action->Id, array("roots", "manage")) ? "active" : null ?>">
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
        </li>
        <?php endif; ?>

        <?php if(Yii::app()->user->allowedGroup('admin_url')): ?>
        <li class="dropdown <?php echo $this->getId() == "admin/url" ? "active" : null ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;
                <?php echo Yii::t("site", "URLs") ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
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
                <li class="<?php echo $this->getId() == "admin/url" && $this->action->Id == "index" && !isset($_GET['type']) ? "active" : null ?>">
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
        </li>
        <?php endif; ?>


        <?php if(Yii::app()->user->checkAccess('admin_tools_index')): ?>
        <li class="<?php echo $this->getId() == "admin/tools" && $this->action->Id == "index" ? "active" : null ?>">
            <a href="<?php echo $this -> createUrl("admin/tools/index") ?>">
                <span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;
                <?php echo Yii::t("admin", "Tools") ?>
            </a>
        </li>
        <?php endif; ?>

        <?php if(Yii::app()->user->isSuperUser()): ?>
        <li class="dropdown <?php echo $this->getId() == "admin/user" ? "active" : null ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;
                <?php echo Yii::t("site", "Users") ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
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
        </li>

        <li class="<?php echo $this->getId() == "admin/systemlog" && $this->action->Id == "index" ? "active" : null ?>">
            <a href="<?php echo $this -> createUrl("admin/systemlog/index") ?>">
                <span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;
                <?php echo Yii::t("system_log", "System log") ?>
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <ul class="nav navbar-nav navbar-right">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;
                <?php echo Yii::t("admin", "Hello, {Username}", array(
                    '{Username}' => '<strong>'.Yii::app() -> user -> name.'</strong>',
                )) ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <?php if(Yii::app()->user->isSuperUser()): ?>
                    <li><a href="<?php echo $this -> createUrl("admin/user/update", array("id"=>Yii::app()->user->id)) ?>"><?php echo Yii::t("user", "Change information") ?></a></li>
                    <li><a href="<?php echo $this -> createUrl("admin/user/resetpassword", array("id"=>Yii::app()->user->id)) ?>"><?php echo Yii::t("user", "Change Password") ?></a></li>
                <?php endif; ?>
                <li><a href="<?php echo $this -> createUrl("admin/auth/logout") ?>"><?php echo Yii::t("admin", "Logout") ?></a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t("site", "Language") ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <?php foreach(Yii::app() -> params["app.languages"] as $lang_id => $language): ?>
                    <?php if($lang_id == Yii::app() -> language) continue; ?>
                    <li><?php echo CHtml::link($language, $this -> createUrl('admin/site/index', array('language' => $lang_id))) ?></li>
                <?php endforeach; ?>
                <li class="divider"></li>
                <li class="disabled"><a href="#"><?php echo Yii::app() -> params["app.languages"][Yii::app() -> language] ?></a></li>
            </ul>
        </li>
    </ul>
</div><!-- /.navbar-collapse -->