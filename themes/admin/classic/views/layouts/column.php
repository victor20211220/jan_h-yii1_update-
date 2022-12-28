<?php $this -> beginContent('//layouts/main'); ?>

<nav class="navbar top-navbar navbar-default" role="navigation">
<?php $this->renderPartial("//site/top_menu") ?>
</nav>

<div id="wrap">
    <div class="container">
        <?php echo $this -> renderPartial("//site/flash") ?>
        <div class="row">
            <div class="col-xs-12 col-md-3 hidden-xs hidden-sm">
                <?php echo $this->renderPartial("//site/left_menu") ?>
            </div>

            <div class="col-xs-12 col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $this -> title ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    <div class="container">
        <p class="text-muted">
            <?php echo Yii::t("site", "Developed by {Copyright}", array(
                "{Copyright}"=>"<strong><a href=\"http://php8developer.com\" target='_blank'>PHP8 Developer</a></strong>"
            )) ?>
        </p>
    </div>
</div>
<?php $this -> endContent(); ?>