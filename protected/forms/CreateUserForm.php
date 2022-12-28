<?php
class CreateUserForm extends CFormModel {
	public $login, $password, $password2, $full_name, $email;

	public function rules() {
		return array(
			array('login, password, password2, full_name, email', 'required'),
			array('login, password, password2', 'length', 'min' => 4),
			array('full_name', 'length', 'max' => 80),
			array('login', 'length', 'max' => 50),
			array('email', 'email'),
			array('password2', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t("user", "Passwords do not match")),
			array('login', 'unique', 'className' => 'User', 'attributeName' => 'login'),
		);
	}

	public function attributeLabels() {
		return array(
			'login' => Yii::t("user", "Login"),
			'password' => Yii::t("user", "Password"),
			'password2' => Yii::t("user", "Re-password"),
			'full_name' => Yii::t("user", "Full Name"),
			'email' => Yii::t("user", "Email"),
		);
	}
}
