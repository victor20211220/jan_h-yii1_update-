<?php

class UrlCounter extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class
     *
     * @param string UpdateUrl
     * @return UrlCounter instance
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
        return '{{category_count}}';
    }

    public function truncateTable() {
        return $this -> getDbConnection() -> createCommand() -> truncateTable($this->tableName());
    }

    public function getStatForCat($categories) {
        $ids = array();
        $statistic = array();
        foreach($categories as $category) {
            $ids[] = $category->id;
        }
        $rows = Yii::app()->db->cache(Yii::app()->params["params.cat_cache_time"])->createCommand()
            -> from("{{category_count}}")
            -> where(array('in', 'category_id', $ids))
            -> queryAll();
        foreach($rows as $row) {
            $statistic[$row['category_id']] = $row['website_count'];
        }
        return $statistic;
    }
}