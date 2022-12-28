<?php
class BrokenLink extends CActiveRecord {
	public $verifyCode;

    /**
     * Returns the static model of the specified AR class
     *
     * @param string $className
     * @return BrokenLink instance
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
		return '{{brokenlink}}';
	}

	public function rules() {
        $rules = array();
        $rules[] = array('website_id', 'required');
        Yii::app()->fc->instance()->appendValidationRule($rules);
        return $rules;
	}


    public function relations() {
        return array(
            'website' => array(self::HAS_ONE, 'Website', array('id' => 'website_id')),
        );
    }

    /**
     * This event is raised before the record is inserted or updated.
     *
     * @param void
     * @return boolean
     */
    public function beforeSave() {
        if(parent::beforeSave()) {
            if($this->isNewRecord) {
                $this -> created_at = date("Y-m-d H:i:s");
                $this -> ip = Yii::app() -> request -> getUserHostAddress();
            }
            return true;
        } else {
            return false;
        }
    }

    public function truncateTable() {
        return $this -> getDbConnection() -> createCommand() -> truncateTable($this->tableName());
    }

    public function attributeLabels() {
        return array(
            "verifyCode"=>Yii::app()->fc->instance()->getModelLabelText(),
        );
    }
}