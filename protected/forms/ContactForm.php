<?php
class ContactForm extends CFormModel {
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	public function rules() {
        $rules = array();
        $rules[] = array('name, email, subject, body', 'required');
        $rules[] = array('email', 'email');
        Yii::app()->fc->instance()->appendValidationRule($rules);
        return $rules;
	}

	public function attributeLabels() {
		return array(
			'name' => Yii::t("contact", "Name"),
			'email' => Yii::t("contact", "Email"),
			'subject' => Yii::t("contact", "Subject"),
			'body' => Yii::t("contact", "Body"),
            "verifyCode"=>Yii::app()->fc->instance()->getModelLabelText(),
		);
	}
}