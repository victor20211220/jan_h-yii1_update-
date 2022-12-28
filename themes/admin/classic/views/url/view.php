<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <th class="text-break" colspan="2">
            <?php echo Yii::t("website", "Basic data") ?>
        </th>
        </thead>
        <tbody>
        <tr>
            <td width="120px">
                <?php echo $website -> getAttributeLabel("url") ?>
            </td>
            <td class="text-break">
                <?php echo CHtml::encode($website -> url); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t("website", "Full category path") ?>
            </td>
            <td>
                <?php echo $website -> category -> formatRootPath(true) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("title") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> title); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("description") ?>
            </td>
            <td>
                <p class="text-break">
                    <?php echo CHtml::encode($website -> description); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("language_id") ?>
            </td>
            <td>
                <?php echo CHtml::encode(Helper::formatLanguage($website -> lang_id)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("country_id") ?>
            </td>
            <td>
                <?php echo CHtml::encode(ECountryList::getInstance(Yii::app() -> language) -> getCountryName($website -> country_id, '-')) ; ?> (<?php echo !empty($website -> country_id) ? $website -> country_id : '--' ?>)
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("type") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> getTypeString()); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("status") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> getStatusString()); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("created_at") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> created_at); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $website -> getAttributeLabel("modified_at") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> modified_at); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t("webiste", "Unique hits") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website->statistic->hits); ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<?php if(Yii::app()->user->checkAccess('admin_url_update')): ?>
<a href="<?php echo $this -> createUrl("admin/url/update", array("id" => $website -> id)) ?>" class="btn btn-primary"><?php echo Yii::t("website", "Edit") ?></a>
<?php endif; ?>

<br/><br/>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <th colspan="2">
            <?php echo Yii::t("website", "Sender information") ?>
        </th>
        </thead>
        <tbody>
        <tr>
            <td width="120px">
                <?php echo $website -> user -> getAttributeLabel("name") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> user -> name) ?>
            </td>
        </tr>
        <tr>
            <td width="120px">
                <?php echo $website -> user -> getAttributeLabel("email") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> user -> email) ?>
            </td>
        </tr>
        <tr>
            <td width="120px">
                <?php echo $website -> user -> getAttributeLabel("comments") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> user -> comments) ?>
            </td>
        </tr>
        <tr>
            <td width="120px">
                <?php echo $website -> user -> getAttributeLabel("ip") ?>
            </td>
            <td>
                <?php echo CHtml::encode($website -> user -> ip) ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>