<?php
class User extends CActiveRecord {
	const STATUS_BLOCK = 0;
	const STATUS_ACTIVE = 1;
	const SUPER_USER = 1;
	const DEFAULT_USER = 0;

    /**
     * @param string $className
     * @return User instance
     */
    public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{user}}';
	}


	/**
	* Hash password
	*
	* @param string password
	* @param string salt
	* @return string hash
	*/
	public function hashPassword($password, $salt) {
		return md5($password . $salt);
	}

	/**
	* Generate random salt. Foreach user it will be unique
	*
	* @param void
	* @return string
	*/
	public function generateSalt() {
		return md5(uniqid(mt_rand(), true));
	}

	/**
	* Declaration of named scopes
	*
	* @param void
	* @return array scopes
	*/
	public function scopes() {
		return array(
            'defaultUser' => array(
                'condition' => 'super_user=:super_user',
                'params'=>array(':super_user'=>self::DEFAULT_USER),
            ),
            'admin'=>array(
                'condition'=>'super_user=:super_user',
                'params'=>array(':super_user'=>self::SUPER_USER),
            ),
		);
	}

	/**
	* Related object declarations
	*
	* @param void
	* @return array relations
	*/
	public function relations() {
		return array(
			'profile' => array(self::HAS_ONE, 'Profile', 'owner_id'),
		);
	}

	public function rules() {
		return array(
			array('login, password', 'required'),
			array('login, password', 'length', 'min' => 4),
			array('login', 'length', 'max' => 50),
			array('login', 'unique', 'attributeName' => 'login', 'on' => 'create'),
            array('search_full_name, search_email, id, login, created_at, status', 'safe', 'on' => 'search'),
		);
	}

    public function beforeDelete() {
        return parent::beforeDelete() AND !$this->isSuperUser();
    }

    public function afterDelete() {
        parent::afterDelete();
        Profile::model() -> deleteByPk($this->id);
        SystemLog::model()->deleteAllByAttributes(array(
            'user_id'=>$this->id,
        ));
    }

	public function beforeSave() {
		if(parent::beforeSave()) {
			$now = date("Y-m-d H:i:s");
			if($this->isNewRecord) {
				$this -> created_at = $now;
				$this -> modified_at = $now;
				$this -> status = self::STATUS_ACTIVE;
				$this -> super_user = self::DEFAULT_USER;
				$this -> salt = $this -> generateSalt();
				$this -> password = $this -> hashPassword($this -> password, $this -> salt);
			} else {
				$this -> modified_at = $now;
			}
			return true;
		} else {
			return false;
		}
	}

    public $search_full_name, $search_email;

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->order = 'created_at DESC';
        $criteria->with='profile';

        $criteria -> compare('id', $this -> id);
        $criteria -> compare('login', $this -> login);
        $criteria -> compare('profile.full_name', $this -> search_full_name);
        $criteria -> compare('profile.email', $this -> search_email);
        $criteria -> compare('created_at', $this -> created_at, true);
        $criteria -> compare('status', $this -> status);

		return new CActiveDataProvider($this -> defaultUser(), array(
			'criteria'=>$criteria,
		));
	}

    public function isBlocked() {
        return $this -> status == self::STATUS_BLOCK;
    }

    public function isSuperUser() {
        return $this->super_user == self::SUPER_USER;
    }
}