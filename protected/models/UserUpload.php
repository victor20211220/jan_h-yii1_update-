<?php
class UserUpload extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class
     *
     * @param string $className
     * @internal param $void
     * @return AR
     */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	* Return table name
	*
	* @param void
	* @return string table name
	*/
	public function tableName() {
		return '{{user_upload}}';
	}

	/**
	* Returns the validation rules for attributes
	*
	* @param void
	* @return array validation rules
	*/
	public function rules() {
		return array(
			array('name, email, comments', 'required'),
			array('name', 'length', 'max' => 100),
			array('email', 'email'),
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
			}
			return true;
		} else {
			return false;
		}
	}

    public function attributeLabels() {
        return array(
            'name' => Yii::t("website", "Name"),
            'email' => Yii::t("website", "Email"),
            'comments' => Yii::t("website", "Comments to Editor"),
            'ip' => 'IP',
        );
    }
}