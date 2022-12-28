<?php
class PremiumCheck extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class
     *
     * @param string
     * @return Website instance
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
        return '{{premiumcheck}}';
    }
}