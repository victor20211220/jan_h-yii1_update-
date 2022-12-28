<?php
class Profile extends CActiveRecord {
	/*
	* Returns the static model of the specified AR class
	*
	* @param void
	* @return AR instance
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
		return '{{profile}}';
	}

    public function rules() {
        return array(
          array('owner_id, full_name, email', 'required'),
        );
    }
}