<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?php echo Yii::t("site", "Categories") ?></h1>
    </div>
    <div class="panel-body">
        <div class="col-xs-12 col-md-12">
            <ul class="list-group">
                <li class="list-group-item">
                    <small><a href="<?php echo $this -> createUrl("search/category") ?>"><?php echo Yii::t("category", "Search Category") ?></a></small>
                </li>
            </ul>
        </div>
        <div class="table-responsive">
            <table class="table index-table">
                <tr>
                    <?php foreach($roots as $i => $root): ?>
                    <td width="<?php echo round(100 / Yii::app() -> params["params.roots_columns"]) ?>%">
                        <a href="<?php echo $this -> createUrl("category/index", array("path" => $root -> slug)) ?>">
                            <?php echo CHtml::encode($root -> title) ?>
                            <?php if(isset($statistic[$root->id])): ?>
                                <span class="badge pull-right"><?php echo $statistic[$root->id] ?></span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <?php if(($i + 1) % Yii::app() -> params["params.roots_columns"] == 0) :?></tr><tr><?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    </div>
</div>

