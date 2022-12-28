<!DOCTYPE html>
<html lang="<?php echo Yii::app() -> language ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="php8developer.com">
<meta name="dcterms.rightsHolder" content="php8developer.com">
<link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true) ?>/favicon.ico" />
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css/flatly-bootstrap-min.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css/app.css" rel="stylesheet">

<?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/js/bootstrap.min.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/app.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/pagepeeker.js') ?>

<?php echo Yii::app()->params['template.head'] ?>
<title><?php echo $this->encodeTitle ? CHtml::encode($this -> title) : $this->title; ?></title>
</head>

<body>
<div id="wrap">
    <nav class="navbar top-navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Yii::app()->request->getBaseUrl(true) ?>">
                    <?php echo Helper::getNavbarBrand(); ?>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="visible-xs"><a href="<?php echo $this -> createUrl("category/index") ?>"><?php echo Yii::t("site", "Categories") ?></a></li>
                    <li><a href="<?php echo $this -> createUrl("country/letters", array("letter" => EAlphabet::getInstance(Yii::app()->language)->getFirstLetter())) ?>"><?php echo Yii::t("site", "Country") ?></a></li>
                    <li><a href="<?php echo $this -> createUrl("site/banners") ?>"><?php echo Yii::t("site", "Banners") ?></a></li>
                    <li><a href="<?php echo $this -> createUrl("site/contact") ?>"><?php echo Yii::t("site", "Contact") ?></a><li>
                </ul>
                <form class="navbar-form navbar-left" role="search" action="<?php echo $this -> createUrl("search/index") ?>">
                    <div class="form-group">
                        <input type="text" name="q" class="form-control" placeholder="<?php echo Yii::t("site", "Search") ?>">
                    </div>
                    <button type="submit" class="btn btn-default"><?php echo Yii::t("site", "Submit") ?></button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t("site", "World") ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach(Yii::app() -> params["app.languages"] as $lang_id => $language): ?>
                                <?php if($lang_id == Yii::app() -> language) continue; ?>
                                <li><?php echo CHtml::link($language, $this -> createUrl('site/index', array('language' => $lang_id))) ?></li>
                            <?php endforeach; ?>
                            <li class="divider"></li>
                            <li class="disabled"><a href="#"><?php echo Yii::app() -> params["app.languages"][Yii::app() -> language] ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

    </nav>

    <div class="container">
        <?php if(!empty(Yii::app()->params['template.banner_top']) AND !Yii::app()->errorHandler->error): ?>
            <div class="row mb-21">
                <div class="col-xs-12">
                    <?php echo Yii::app()->params['template.banner_top'] ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <?php echo $this -> renderPartial("//site/flash") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-3 hidden-xs">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title"><?php echo Yii::t("site", "Categories") ?></h3>
                  </div>
                  <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                        $roots = Category::model() -> getRoots();
                        $statistic = UrlCounter::model()->getStatForCat($roots);
                        foreach($roots as $category):
                        ?>
                        <li>
                            <a href="<?php echo $this -> createUrl("category/index", array("path" => $category -> slug)) ?>">
                                <?php if(isset($statistic[$category->id])): ?>
                                <span class="badge pull-right"><?php echo $statistic[$category->id] ?></span>
                                <?php endif; ?>
                                <?php echo $category -> title ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title"><?php echo Yii::t("site", "World") ?></h3>
                  </div>
                  <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach(Yii::app() -> params["app.languages"] as $lang_id => $language): ?>
                        <?php if($lang_id == Yii::app() -> language) continue; ?>
                        <li><?php echo CHtml::link($language, $this -> createUrl('site/index', array('language' => $lang_id))) ?></li>
                        <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-9">
                <?php echo $content; ?>
            </div>
        </div>

        <?php if(!empty(Yii::app()->params['template.banner_bottom']) AND !Yii::app()->errorHandler->error): ?>
            <div class="row mb-21">
                <div class="col-xs-12">
                    <?php echo Yii::app()->params['template.banner_bottom'] ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<div id="footer">
    <div class="container">
        <p class="text-muted">
            <?php echo Yii::app()->params['template.footer']; ?>
            <?php if(!empty(Yii::app()->params['pagepeeker.verify'])): ?>
                &nbsp;|&nbsp;
                <?php echo Yii::app()->params['pagepeeker.verify']; ?>
            <?php endif; ?>
        </p>
    </div>
</div>

</body>
</html>