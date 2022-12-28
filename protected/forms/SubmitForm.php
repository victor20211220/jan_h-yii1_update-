<?php
class SubmitForm extends CFormModel {
	public
		$url = 'http://', $title, $description, $name, $md5url, $website_id,
        $changes, $email, $comments, $category_id, $country_id,
        $verifyCode, $lang_id, $status = Website::STATUS_WAITING, $type = Website::TYPE_REGULAR;

	/**
	* Returns the validation rules for attributes
	*
	* @param void
	* @return array validation rules
	*/
    public function rules() {
        $rules = array();
        $rules[] = array('url, title, description, status, type, category_id', 'required');
        $rules[] = array('type', 'in', 'range' => Website::typeArray());
        $rules[] = array('status', 'in', 'range' => Website::statusArray());
        $rules[] = array('title', 'length', 'max' => 150);
        $rules[] = array('description', 'length', 'min' => 100);
        $rules[] = array('url', 'url');
        $rules[] = array('title, description', 'filter', 'filter' => 'trim');
        $rules[] = array('country_id', 'ext.validators.CountryValidator', 'allowEmpty' => false, 'message' => Yii::t("website", "Invalid country name"));
        $rules[] = array('url', 'ext.validators.UrlReachableValidator', 'message' => Yii::t("website", "Url is not reachable"));
        $rules[] = array('category_id', 'exist', 'className' => 'Category', 'attributeName' => 'id');
        $rules[] = array('url', 'existsUrl');
        $rules[] = array('name, email, comments', 'required', 'on' => array('submit', 'userUpdate'));
        $rules[] = array('name', 'length', 'max' => 100, 'on' => array('submit', 'userUpdate'));
        $rules[] = array('email', 'length', 'max' => 80, 'on' => array('submit', 'userUpdate'));
        $rules[] = array('email', 'email', 'on' => array('submit', 'userUpdate'));
        $rules[] = array('website_id', 'required', 'on' => 'userUpdate');
        $rules[] = array('changes', 'required', 'on' => 'userUpdate');
        Yii::app()->fc->instance()->appendValidationRule($rules, array(
            'on' => array('submit', 'userUpdate')
        ));
        return $rules;
    }

    public function existsUrl(){
        //if(!$this->hasErrors()) {
            $unique = in_array($this -> getScenario(), array('userUpdate', 'adminUpdate'));

            $conditions = $unique ? 'id != :website_id' : '';
            $params = $unique ? array(':website_id' => $this->website_id) : array();
            $count = Website::model()->countByAttributes(array(
                'md5url'=>Helper::md5Url($this->url)
            ), $conditions, $params);
            if ( $count ) {
                $this->addError("url", Yii::t("website", "Link already exists"));
            }
        //}
    }

    /**
	* Returns the attribute labels
	*
	* @param void
	* @return array attribute labels
	*/
	public function attributeLabels() {
		return array(
			'url' => Yii::t("website", "Url"),
			'title' => Yii::t("website", "Title"),
			'description' => Yii::t("website", "Description"),
			'country_id' => Yii::t("website", "Country"),
			"name" => Yii::t("website", "Your Name"),
			"email" => Yii::t("website", "Contact E-Mail"),
			"comments" => Yii::t("website", "Comments to Editor"),
			"lang_id" => Yii::t("website", "Language ID"),
			"type" => Yii::t("website", "Submission Type"),
            "changes" => Yii::t("website", "Comments (Nature or changes)"),
            "verifyCode"=>Yii::app()->fc->instance()->getModelLabelText(),
		);
	}
}