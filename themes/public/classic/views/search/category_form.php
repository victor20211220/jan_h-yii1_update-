<form class="form-horizontal" method="GET">
		<div class="form-group">
			<label for="search_category" class="col-lg-2 control-label">Text</label>
			<div class="col-lg-10">
				<input name="q" id="search_category" class="form-control" value="<?php echo CHtml::encode(Helper::_v($_GET, 'q')) ?>">
			</div>
		</div>

		<div class="form-group">
			<div class="col-lg-10 col-lg-offset-2">
				<input type="submit" class="btn btn-large btn-primary" value="<?php echo Yii::t("site", "Submit") ?>">
			</div>
		</div>
</form>