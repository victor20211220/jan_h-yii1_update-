<?php
class ResetPasswordForm extends CFormModel {
    public $password, $password2;
    public function rules() {
        return array(
            array('password, password2', 'required'),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t("user", "Passwords do not match")),
        );
    }
    public function attributeLabels() {
        return array(
            'password' => Yii::t("user", "Password"),
            'password2' => Yii::t("user", "Re-password"),
        );
    }
}