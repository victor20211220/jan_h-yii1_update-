<?php
class AuthController extends BackController {
	public $layout = 'login_column';

	public function actionLogin() {
		$user = Yii::app() -> user;
		$cnt = Yii::app() -> params["params.admin_bad_login_count"];
		$scenario = ($cnt >= 0 AND $user -> getState('badLoginCount', 0) >= $cnt) ? 'loginLimit' : null;
		Yii::app() -> getClientScript() -> registerCssFile(Yii::app() -> theme -> baseUrl ."/css/signin.css");

		$loginForm = new LoginForm ($scenario);

		if(Yii::app() -> request -> isPostRequest AND !empty($_POST['LoginForm'])) {
			$loginForm -> attributes = $_POST['LoginForm'];
			if($loginForm -> validate()) {
				$user -> setState('badLoginCount', null);
				$this -> redirect(Yii::app() -> user -> returnUrl);
			} else {
				$badLoginCount = $user -> getState('badLoginCount', 0);
				$user -> setState('badLoginCount', $badLoginCount + 1);
			}
		}

		$this -> render("//user/login_form", array(
			'model' => $loginForm,
			'user' => $user,
			'cnt' => $cnt,
            'scenario' => $scenario,
		));
	}

	public function actionLogout() {
		Yii::app() -> user -> logout();
		Yii::app() -> session -> open();
		Yii::app() -> user -> setFlash('warning', Yii::t("user", "You have been disconnected from the session"));
		Yii::app() -> user -> setReturnUrl(Yii::app()->request->urlReferrer);
        $this -> redirect(array("admin/auth/login"));
	}
}