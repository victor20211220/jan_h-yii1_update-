<?php
class Website extends CActiveRecord {

	/**
	* Webstie approve status
	*
	* @var const
	*/
	const STATUS_APPROVED = 1;

	/**
	* Webstie waiting status
	*
	* @var const
	*/
	const STATUS_WAITING = 0;

	/**
	* Webstie reject status
	*
	* @var const
	*/
	const STATUS_REJECTED = -1;

	/**
	* Webstie approve status
	*
	* @var const
	*/
	const TYPE_PREMIUM = 1;

	/**
	* Webstie not approve status
	*
	* @var const
	*/
	const TYPE_REGULAR = 0;

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
		return '{{website}}';
	}

	/**
	* Related object declarations
	*
	* @param void
	* @return array relations
	*/
	public function relations() {
		return array(
			'user' => array(self::HAS_ONE, 'UserUpload', array('website_id' => 'id')),
			'category' => array(self::HAS_ONE, 'Category', array('id' => 'category_id')),
			'statistic' => array(self::HAS_ONE, 'Statistic', array('website_id' => 'id'), 'joinType'=>'INNER JOIN', 'select'=>'hits'),
		);
	}


	/**
	* Returns the validation rules for attributes
	*
	* @param void
	* @return array validation rules
	*/
	public function rules() {
		return array(
            array('url, title, description, status, type, category_id, lang_id', 'required'),
            array('type', 'in', 'range' => $this->typeArray()),
            array('status', 'in', 'range' => $this->statusArray()),
            array('title', 'length', 'max' => 150),
            array('url', 'url'),
            array('lang_id', 'in', 'range' => array_keys(Yii::app() -> params['app.languages'])),
            array('title, description', 'filter', 'filter' => 'trim'),
            array('country_id', 'ext.validators.CountryValidator', 'allowEmpty' => false, 'message' => Yii::t("website", "Invalid country name")),
            array('url', 'ext.validators.UrlReachableValidator', 'message' => Yii::t("website", "Url is not reachable")),
            array('category_id', 'exist', 'className' => 'Category', 'attributeName' => 'id'),
            array('md5url', 'unique', 'message' => Yii::t("website", "Link already exists")),

            array('url, type, id, status', 'safe', 'on'=>'search'),
        );
	}

	/**
	* Declaration of named scopes
	*
	* @param void
	* @return array scopes
	*/
	public function scopes() {
		return array(
            'all' => array(
                'order' => 't.created_at DESC',
            ),
			'premiumQueue' => array(
				'condition' => 'status = :status AND type = :type',
				'params' => array(':status' => self::STATUS_WAITING, ':type' => self::TYPE_PREMIUM),
                'order' => 't.created_at ASC',
			),
			'regularQueue' => array(
				'condition' => 'status = :status AND type = :type',
				'params' => array(':status' => self::STATUS_WAITING, ':type' => self::TYPE_REGULAR),
                'order' => 't.created_at ASC',
			),
            'premium'=>array(
                'condition'=>'type=:type',
                'params'=>array(':type'=>self::TYPE_PREMIUM),
            ),
		);
	}

	public function category($params) {
		$this -> getDbCriteria() -> mergeWith(array(
			'condition' => 'category_id = :category_id',
			'params' => array(':category_id' => $params['category_id']),
		));
		return $this;
	}

	public function popularRelated($limit=10) {
		$this->getDbCriteria()->mergeWith(array(
				'with'=>'statistic',
				'select'=>'t.id, t.title, t.description, t.url',
				'order'=>'statistic.hits DESC',
				'limit'=>(int) $limit,
				'condition'=>'t.id != :id AND t.category_id = :cat_id AND t.status = :status AND statistic.hits > 0',
				'params'=>array(
					':id'=>$this->id,
					':cat_id'=>$this->category_id,
					':status'=>self::STATUS_APPROVED,
				),
		));
		return $this;
	}

	public function popular($limit=10) {
		$this->getDbCriteria()->mergeWith(array(
			'with'=>'statistic',
			'select' => 't.id, t.title, t.description, t.url',
			'order'=>'statistic.hits DESC',
			'limit'=>(int) $limit,
			'condition'=>'t.lang_id=:lang_id AND t.status=:status AND statistic.hits > 0',
			'params'=>array(
				':lang_id'=>Yii::app()->language,
				':status'=>self::STATUS_APPROVED,
			),
		));
		return $this;
	}

	public function recentlyApproved($limit = 20) {
		$this -> getDbCriteria() -> mergeWith(array(
			'order' => 'created_at DESC',
			'limit' => $limit,
			'condition' => 'status=:status AND lang_id=:lang_id',
			'params' => array(':status' => self::STATUS_APPROVED, ':lang_id' => Yii::app() -> language),
		));
		return $this;
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
			'id' => Yii::t("website", "ID"),
			'lang_id' => Yii::t("website", "Language ID"),
			'category_id' => Yii::t("website", "Category ID"),
			'created_at' => Yii::t("website", "Created at"),
			'modified_at' => Yii::t("website", "Modified at"),
			'language_id' => Yii::t("website", "Language ID"),
			'status' => Yii::t("website", "Status"),
			'type' => Yii::t("website", "Type"),
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
			$now = date("Y-m-d H:i:s");
			if($this->isNewRecord) {
				$this -> status = self::STATUS_WAITING;
                $this -> url = trim($this -> url, "/");
				$this -> md5url = Helper::md5Url($this -> url);
				$this -> created_at = $now;
				$this -> modified_at = $now;
			} else {
				$this -> modified_at = $now;
			}
			return true;
		} else {
			return false;
		}
	}

    public static function typeArray() {
        return array(self::TYPE_REGULAR, self::TYPE_PREMIUM);
    }

    public static function statusArray() {
        return array(self::STATUS_REJECTED, self::STATUS_WAITING, self::STATUS_APPROVED);
    }

	/**
	* Generates array of possible website's types. Ex: premiu, regular
	*
	* @param void
	* @return array of types
	*/
	public function getTypeList() {
		return array(
			self::TYPE_REGULAR => Yii::t("website", "Regular"),
			self::TYPE_PREMIUM => Yii::t("website", "Premium"),
		);
	}

	/**
	* Generates array of possible website's statuses. Ex: approved, rejected, waiting
	*
	* @param void
	* @return array of statuses
	*/
	public function getStatusList() {
		return array(
			self::STATUS_APPROVED => Yii::t("website", "Approved"),
			self::STATUS_WAITING => Yii::t("website", "Waiting"),
			self::STATUS_REJECTED => Yii::t("website", "Rejected"),
		);
	}

	public function getStatusString($id = false, $status = false) {
        $status = $id === false ? $this -> status : $status;
		switch($status) {
			case self::STATUS_REJECTED:
				return $id == false ? Yii::t("website", "Rejected") : "Rejected";
			break;
			case self::STATUS_WAITING:
				return $id == false ? Yii::t("website", "Waiting") : "Waiting";
			break;
			case self::STATUS_APPROVED:
				return $id == false ? Yii::t("website", "Approved") : "Approved";
			break;
			default:
				return $id == false ? Yii::t("website", "Unknown") : "Unknown";
			return;
		}
	}

	public function getEmailString($part, array $params = array(), $id = false, $status=false, $type=false) {
		$type = $id == false ? $this -> getTypeString() : $this->getTypeString(true, $type);
		$status = $id == false ? $this -> getStatusString() : $this->getStatusString(true, $status);
		return Yii::t("email", "Email {$part} {$status} {$type}", $params);
	}

	public function getTypeString($id = false, $type = false) {
        $type = $id === false ? $this -> type : $type;
        switch($type) {
			case self::TYPE_REGULAR:
                return $id == false ? Yii::t("website", "Regular") : "Regular";
			break;
			case self::TYPE_PREMIUM:
				return $id == false ? Yii::t("website", "Premium") : "Premium";
			break;
			default:
				return $id == false ? Yii::t("website", "Unknown") : "Unknown";
			return;
		}
	}

	public function search($scope, $params = array()) {
        $criteria = new CDbCriteria();
        $criteria -> compare('t.id', $this -> id);
        $criteria -> compare('t.url', $this -> url, true);
        $criteria -> compare('t.type', $this -> type);
        $criteria -> compare('t.status', $this -> status);

        $criteria -> with = array(
            'category' => array(
                'select' => 'title',
            )
        );
        return new CActiveDataProvider($this -> $scope($params), array(
			'criteria' => $criteria,
            'pagination'=>array(
                'pageSize' => Yii::app() -> params["params.admin_url_per_page"],
                'pageVar' => 'page',
            ),
		));
	}

	public function getViewUrl($htmlOptions = array()) {
		$um = Yii::app() -> getUrlManager();
		if(!isset($htmlOptions['target'])) {
			$htmlOptions['target'] = '_blank';
		}
		return CHtml::link($this -> title, $um -> createUrl("admin/url/view", array("id" => $this -> id)), $htmlOptions);
	}

	public function isPremium() {
		return $this -> type == self::TYPE_PREMIUM;
	}

    public function getRelatedWebsitesInCategory() {
        $total = $this->count("category_id=:cat_id AND status=:status AND lang_id=:lang_id AND id!=:id", array(
            ":cat_id"=>$this->category_id,
            ":status"=>self::STATUS_APPROVED,
            ":lang_id"=>Yii::app()->language,
            ":id"=>$this->id,
        ));

        $limit = Yii::app() -> params["params.related_website_count"];
        $maxOffset = $total - $limit;
        $offset = $maxOffset > 0 ? mt_rand(0, $maxOffset) : 0;

        $criteria = new CDbCriteria();
        $criteria -> select = "id, title, description, url";
        $criteria -> condition = 'category_id=:cat_id AND id!=:id AND status=:status AND lang_id=:lang_id';
        $criteria -> params = array(
            ':status'=>self::STATUS_APPROVED,
            ':lang_id'=>Yii::app()->language,
            ':id'=>$this->id,
            ':cat_id'=>$this->category_id,
        );
        $criteria -> offset = $offset;
        $criteria -> limit = $limit;
        $data = $this -> findAll($criteria);
        return $data;
    }

    public static function getStatisticByCountries(array $countries) {
			$command = Yii::app()->db->cache(Yii::app()->params["params.cat_cache_time"])->createCommand();
			$statistic = $command
				-> select('upper(country_id) as country_id, count(id)')
				-> from('{{website}}')
				-> where(
					array('and', array('and', 'status=:status', 'lang_id=:lang_id'), array('in', 'country_id', $countries)),
					array(':lang_id'=>Yii::app()->language, ':status'=> self::STATUS_APPROVED)
				)
				-> group('country_id')
				-> queryAll();
			return CHtml::listData($statistic, 'country_id', 'count(id)');
    }
}