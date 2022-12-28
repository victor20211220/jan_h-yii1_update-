<?php
class SystemLog extends CActiveRecord {
	const VISIBLE = 1;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{system_log}}';
	}

	public function relations() {
		return array(
			'profile' => array(self::HAS_ONE, 'Profile', array('owner_id' => 'user_id')),
		);
	}

	/**
	* This event is raised before the record is inserted or updated.
	*
	* @param void
	* @return void
	*/
	public function beforeSave() {
		if(parent::beforeSave() AND Yii::app()->params["params.admin_enable_action_logging"]) {
			$this -> created_at = date("Y-m-d H:i:s");
			$this -> user_id = Yii::app() -> user -> id;
			$this -> visible = self::VISIBLE;
			if(!is_array($this -> params)) {
				$this -> params	= array();
			}
			$params = array(
				'{User}' => '<strong>'. Yii::app() -> user -> name .'</strong>',
			);
			$this -> params = serialize(array_merge($this -> params, $params));
			return true;
		} else {
			return false;
		}
	}

	public function rules() {
		return array(
			array('log, module', 'required'),
			array('params', 'safe'),
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t("system_log", "ID"),
			'user_id' => Yii::t("system_log", "User"),
			'module' => Yii::t("system_log", "Module"),
			'log' => Yii::t("system_log", "Log"),
			'created_at' => Yii::t("system_log", "Created at"),
		);
	}

	public function truncateTable() {
        return $this -> getDbConnection() -> createCommand() -> truncateTable($this->tableName());
    }
}