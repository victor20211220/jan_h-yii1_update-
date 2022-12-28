<form class="form-horizontal" method="POST">
    <fieldset>
        <?php foreach($groupItems as $group=>$items): ?>
        <legend>
            <?php echo CHtml::encode(Yii::t("system_log", $group)) ?>
        </legend>
        <?php foreach($items as $id=>$item): ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="<?php echo $id ?>"<?php echo isset($userItems[$id]) ? " checked" : null ?> value="1">
                    <?php echo CHtml::encode(Yii::t("permissions", $id)) ?>
                </label>
            </div>
        <?php endforeach; ?>
        <br/><br/>
        <?php endforeach; ?>
    </fieldset>
    <input type="submit" class="btn btn-primary" value="<?php echo Yii::t("site", "Submit") ?>">
    <a href="" class="btn btn-default"><?php echo Yii::t("site", "Cancel") ?></a>
</form>