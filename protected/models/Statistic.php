<?php
class Statistic extends CActiveRecord {
    /**
     * Return the static model of the specified AR class
     *
     * @param string $className
     * @internal param $void
     * @return Statistic instance
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
		return '{{statistic}}';
	}

    public function relations() {
        return array(
          'website' => array(
              self::HAS_ONE,
              'Website',
              array('id' => 'website_id'),
              'select' => 'website.id, website.title, website.description, website.url',
              'joinType'=>'LEFT OUTER JOIN',
          )
        );
    }

    public function popular($limit = 10) {
        $this->getDbCriteria()->mergeWith(array(
            'order' => $this -> getTableAlias(false, false).'.hits DESC',
            'limit' => (int) $limit,
        ));
        return $this;
    }
}