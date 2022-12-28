<?php
class EmailForm extends CFormModel {
	public
		$to, $subject, $body;
	
	public function rules() {
		return array(
			array('to, subject, body', 'required'),
			array('to', 'email'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'subject' => Yii::t("website", "Subject"),
			'to' => Yii::t("website", "To"),
			'body' => Yii::t("website", "Body"),
		);
	}
}