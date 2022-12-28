<?php
class LoginForm extends CFormModel {
	public $login;
	public $password;
	public $verifyCode;
	public $remember_me;

	private $_identity;

	public function rules() {
	    $rules = array();
	    $rules[] = array('login, password', 'required');
	    $rules[] = array('login', 'length', 'max' => 50);
	    $rules[] = array('remember_me', 'boolean');
        Yii::app()->fc->instance()->appendValidationRule($rules, array(
            'on' => 'loginLimit'
        ));
        $rules[] = array('password', 'authenticate');
        return $rules;
	}

	public function attributeLabels() {
		return array(
			'login' => Yii::t("user", "Login"),
			'password' => Yii::t("user", "Password"),
			'remember_me' => Yii::t("user", "Rember me"),
            "verifyCode"=>Yii::app()->fc->instance()->getModelLabelText(),
		);
	}

	public function authenticate() {
		if($this -> hasErrors()) {
			return false;
		}
		$this -> _identity = new UserIdentity($this -> login, $this -> password);
		if($this -> _identity-> authenticate()) {
            $duration = $this -> remember_me ? 60 * 60 * 24 * 7 : 0;
			Yii::app() -> user -> login($this -> _identity, $duration);
		} else {
			$this -> addError("login", $this -> _identity -> errorMessage);
			$this -> addError("password", null);
		}
	}
}