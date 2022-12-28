<div class="row">
    <?php foreach($roots as $root): ?>
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail well-bg">
            <div class="caption">
                <h3><?php echo $root -> title ?></h3>
                <p>
                    <?php echo Yii::t("category", "Language ID") ?> : <?php echo $root -> lang_id ?> (<?php echo Yii::app() -> params["app.languages"][$root -> lang_id] ?>)
                </p>

                <?php if(Yii::app()->user->checkAccess('admin_category_manage')): ?>
                    <a href="<?php echo $this -> createUrl("admin/category/manage", array("id" => $root -> id)) ?>" class="btn btn-primary">
                        <?php echo Yii::t("category", "Manage tree") ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if(!empty($create) AND Yii::app()->user->checkAccess('admin_category_createroot')): ?>

<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <div class="caption">
                <h3><?php echo Yii::t("category", "Create root") ?></h3>
                <form action="<?php echo $this -> createUrl("admin/category/createroot") ?>" method="post">
                    <select name="lang_id" class="form-control">
                        <?php foreach($create as $lang_id => $language): ?>
                            <option value="<?php echo $lang_id ?>"><?php echo $language ?> (<?php echo $lang_id ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <br/>
                    <input type="submit" value="<?php echo Yii::t("category", "Create tree") ?>" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>


