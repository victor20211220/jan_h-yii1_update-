<?php
class UpdateUrl extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class
     *
     * @param string UpdateUrl
     * @return CActiveRecord instance
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
        return '{{update}}';
    }

    public function rules() {
        return array(
            array('website_id, lang_id, title, description, url, name, email, comments, changes', 'required'),
            array('country_id', 'ext.validators.CountryValidator', 'allowEmpty' => true, 'message' => Yii::t("website", "Invalid country name")),
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

    public function relations() {
        return array(
            'website' => array(self::HAS_ONE, 'Website', array('id' => 'website_id')),
        );
    }

    public function truncateTable() {
        return $this -> getDbConnection() -> createCommand() -> truncateTable($this->tableName());
    }
}