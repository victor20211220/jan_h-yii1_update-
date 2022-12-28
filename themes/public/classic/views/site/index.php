<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title">
            <?php echo Yii::t("website", "Top {Number} listing", array(
                "{Number}" => Yii::app() -> params["params.top_listing"],
            )) ?>
        </h1>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table index-table">
                <tr>
                <?php foreach($popular as $i => $p): ?>
                <td width="<?php echo round(100 / Yii::app() -> params["params.top_listing_columns"]) ?>%">
                    <a href="<?php echo $this -> createUrl("url/index", array('slug' => Helper::slug($p -> title), 'id' => $p -> id)); ?>">
                        <?php echo Helper::mb_ucfirst(CHtml::encode($p -> title)) ?>
                    </a>
                    <small>(<?php echo Yii::t("website", "Unique hits") ?> : <?php echo $p->statistic->hits ?>)</small>
                </td>
                <?php if(($i + 1) % Yii::app() -> params["params.top_listing_columns"] == 0) :?></tr><tr><?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title">
            <?php echo Yii::t("website", "New {Number} listing", array(
                "{Number}" => Yii::app() -> params["params.new_listing"],
            )) ?>
        </h1>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table index-table">
                <tr>
                    <?php foreach($newest as $i => $new): ?>
                    <td width="<?php echo round(100 / Yii::app() -> params["params.new_listing_columns"]) ?>%">
                        <a href="<?php echo $this -> createUrl("url/index", array('slug' => Helper::slug($new -> title), 'id' => $new -> id)); ?>">
                            <?php echo Helper::mb_ucfirst(CHtml::encode($new -> title)) ?>
                        </a>
                        <small>(<?php echo Yii::app() -> dateFormatter -> formatDateTime($new -> created_at, 'long',  null); ?>)</small>
                    </td>
                    <?php if(($i + 1) % Yii::app() -> params["params.new_listing_columns"] == 0) :?></tr><tr><?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    </div>
</div>