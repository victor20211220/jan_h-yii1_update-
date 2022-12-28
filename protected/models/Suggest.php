<?php
class Suggest extends CActiveRecord {

	public $verifyCode;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{suggest}}';
	}

	public function rules() {
        $rules = array();
        $rules[] = array('category_id, title, comments', 'required');
        $rules[] = array('title', 'length', 'max' => 50);
        $rules[] = array('comments', 'length', 'max' => 500);
        Yii::app()->fc->instance()->appendValidationRule($rules);
        return $rules;
	}

	/**
	* Returns the attribute labels
	*
	* @param void
	* @return array attribute labels
	*/
	public function attributeLabels() {
		return array(
			'title' => Yii::t("category", "Suggested Sub Category"),
			'comments' => Yii::t("category", "Comments to Editor"),
			'created_at' => Yii::t("category", "Suggested at"),
			'id' => 'ID',
            "verifyCode"=>Yii::app()->fc->instance()->getModelLabelText(),
		);
	}

	/**
	* This event is raised before the record is inserted or updated.
	*
	* @param void
	* @return void
	*/
	public function beforeSave() {
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				$this -> ip = Yii::app() -> request -> getUserHostAddress();
				$this -> created_at = date("Y-m-d H:i:s");
			}
			return true;
		} else {
			return false;
		}
	}

	public function truncateTable() {
     return $this -> getDbConnection() -> createCommand() -> truncateTable($this->tableName());
  }
}