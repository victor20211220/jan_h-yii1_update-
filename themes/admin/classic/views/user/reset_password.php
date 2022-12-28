<div class="row">

    <div class="col-xs-12 col-sm-6 col-md-8">
        <form class="form-horizontal" method="POST">
            <fieldset>
                <legend>
                    <?php echo $this -> title ?>
                </legend>

                <?php echo CHtml::errorSummary($form, null, null, array(
                    'class' => 'alert alert-danger',
                )); ?>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($form, 'password', array('class' => 'col-lg-3 control-label')); ?>
                    <div class="col-lg-9">
                        <?php echo CHtml::activePasswordField($form, 'password', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo CHtml::activeLabel($form, 'password2', array('class' => 'col-lg-3 control-label')); ?>
                    <div class="col-lg-9">
                        <?php echo CHtml::activePasswordField($form, 'password2', array('class' => 'form-control')); ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <?php echo CHtml::submitButton(Yii::t("site", "Submit"), array(
                            'class' => 'btn btn-large btn-primary',
                        )); ?>
                    </div>
                </div>

                <fieldset>
        </form>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <ul class="nav nav-pills nav-stacked">

            <li>
                <a href="<?php echo $this -> createUrl("admin/user/view", array("id" => $user -> id)) ?>">
                    <?php echo Yii::t("user", "User Details") ?>
                </a>
            </li>

            <?php if(!$user->isSuperUser()): ?>
            <li>
                <a href="<?php echo $this -> createUrl("admin/user/permissions", array("id" => $user -> id))?>">
                    <?php echo Yii::t("user", "Change Permissions") ?>
                </a>
            </li>
            <?php endif; ?>

            <?php if(!$user->isSuperUser()): ?>
            <li>
                <?php if($user -> isBlocked()): ?>
                    <a id="unblock_user" href="<?php echo $this -> createUrl("admin/user/changestatus", array("id" => $user -> id, "status" => "unblock"))?>">
                        <?php echo Yii::t("user", "Unblock User") ?>
                    </a>
                <?php else: ?>
                    <a id="block_user" href="<?php echo $this -> createUrl("admin/user/changestatus", array("id" => $user -> id, "status" => "block"))?>">
                        <?php echo Yii::t("user", "Block User") ?>
                    </a>
                <?php endif; ?>
            </li>
            <?php endif; ?>

            <li>
                <a href="<?php echo $this -> createUrl("admin/user/update", array("id" => $user -> id))?>">
                    <?php echo Yii::t("user", "Update Info") ?>
                </a>
            </li>

            <?php if(!$user->isSuperUser()): ?>
            <li>
                <a id="delete_user" href="<?php echo $this -> createUrl("admin/user/delete", array("id" => $user -> id))?>">
                    <?php echo Yii::t("user", "Delete User") ?>
                </a>
            </li>
            <?php endif; ?>

            <li class="active">
                <a href="<?php echo $this -> createUrl("admin/user/resetpassword", array("id" => $user -> id)) ?>">
                    <?php echo Yii::t("user", "Reset Password") ?>
                </a>
            </li>
        </ul>
    </div>
</div>
