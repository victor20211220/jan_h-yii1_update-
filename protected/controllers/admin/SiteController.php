<?php
class SiteController extends BackController {

	public function actionIndex() {
        $this->title=Yii::t("admin", "Admin Panel");
        $this -> render("//site/index", array(
		));
	}
}