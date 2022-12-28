<div class="row">

<div class="col-xs-12 col-sm-6 col-md-8">
	<div class="table-responsive ">
		<table class="table">
			<thead>
			<tr>
				<th><?php echo Yii::t("user", "User Details") ?></th>
				<th></th>
			</tr>
			</thead>
			<tbody>
					<tr>
						<td width="150px"><?php echo Yii::t("user", "ID") ?></td>
						<td><?php echo CHtml::encode($user -> id) ?></td>
					</tr>
					<tr>
						<td><?php echo Yii::t("user", "Login") ?></td>
						<td><?php echo Chtml::encode($user -> login) ?></td>
					</tr>
					<tr>
						<td><?php echo Yii::t("user", "Full Name") ?></td>
						<td><?php echo CHtml::encode($user -> profile -> full_name) ?></td>
					</tr>
					<tr>
						<td><?php echo Yii::t("user", "Email") ?></td>
						<td><?php echo CHtml::encode($user -> profile -> email) ?></td>
					</tr>
                    <tr class="<?php echo $user -> isBlocked() ? " warning": " success" ?>">
                        <td><?php echo Yii::t("user", "Status") ?></td>
                        <td><?php echo $user -> isBlocked() ? Yii::t("user", "Blocked") : Yii::t("user", "Active") ?></td>
                    </tr>
			</tbody>
		</table>
	</div>
</div>

<div class="col-xs-6 col-md-4">
	<ul class="nav nav-pills nav-stacked">

		<li class="active">
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

		<li>
			<a href="<?php echo $this -> createUrl("admin/user/resetpassword", array("id" => $user -> id)) ?>">
				<?php echo Yii::t("user", "Reset Password") ?>
			</a>
		</li>


	</ul>
</div>


</div>