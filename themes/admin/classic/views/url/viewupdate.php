<?php if($website == null): ?>
<p><?php echo Yii::t("website", "Website with ID {ID} was deleted") ?></p>
<?php else: ?>
    <div class="table-responsive">
        <div class="pull-right">
            <?php if(Yii::app()->user->checkAccess('admin_url_view')): ?>
            <a href="<?php echo $this -> createUrl("admin/url/view", array("id" => $website -> id)) ?>" target="_blank" class="btn btn-primary"><?php echo Yii::t("website", "View") ?></a>
            <?php endif; ?>

            <?php if(Yii::app()->user->checkAccess('admin_url_update')): ?>
            <a href="<?php echo $this -> createUrl("admin/url/update", array("id" => $website -> id)) ?>" target="_blank" class="btn btn-default"><?php echo Yii::t("website", "Edit") ?></a>
            <?php endif; ?>

            <?php if(Yii::app()->user->checkAccess('admin_url_deletecustomupdate')): ?>
            <a href="<?php echo $this -> createUrl("admin/url/deletecustomupdate", array("id" => $website -> id, "type" => "deleterow")) ?>" class="btn btn-danger" onclick="return confirm('<?php echo Yii::t("system_log", "Are you sure want to remove this report?") ?>') ? true : false;"><?php echo Yii::t("system_log", "Remove this report") ?></a>
            <?php endif; ?>

        </div>
        <table class="table">
            <thead>
                <th colspan="2">
                    <a target="_blank" href="<?php echo $this -> createUrl("url/index", array('slug' => Helper::slug($website -> title), 'id' => $website -> id, 'language'=>$website->lang_id)); ?>">
                        <?php echo Yii::t("website", "View on the web") ?>
                    </a>
                </th>

            </thead>
            <tbody>
                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "Old Url") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($website->url) ?>
                    </td>
                </tr>

                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "New Url") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> url) ?>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "Old title") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($website->title) ?>
                    </td>
                </tr>

                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "New title") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> title) ?>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>

                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "Old description") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($website->description) ?>
                    </td>
                </tr>

                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "New description") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> description) ?>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "Old country") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(ECountryList::getInstance(Yii::app()->language)->getCountryName($website->country_id, '-')) ?>
                    </td>
                </tr>

                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "New country") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(ECountryList::getInstance(Yii::app()->language)->getCountryName($update->country_id, '-')) ?>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "Old language") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($website->lang_id) ?>
                    </td>
                </tr>

                <tr class="active">
                    <td>
                        <?php echo Yii::t("website", "New language") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> lang_id) ?>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <th colspan="2"><?php echo Yii::t("website", "Comments to Editor") ?></th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo Yii::t("website", "Name") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> name) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Yii::t("website", "Email") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> email) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Yii::t("website", "Comments to Editor") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> comments) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo Yii::t("website", "Comments (Nature or changes)") ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> changes) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        IP
                    </td>
                    <td>
                        <?php echo CHtml::encode($update -> ip) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>