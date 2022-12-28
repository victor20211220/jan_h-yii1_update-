<?php
class UserIdentity extends CUserIdentity {
	private $_id;

    const ERROR_USER_BLOCKED = 3;

	public function authenticate() {
		$user = User::model() -> findByAttributes(array(
			'login' => $this -> username,
		));
		
		if($user === null) {
			$this -> errorCode = self::ERROR_USERNAME_INVALID;
            $this -> errorMessage = Yii::t("user", "Invalid login or password");
		}
		else if($user -> hashPassword($this -> password, $user -> salt) != $user -> password) {
			$this -> errorCode = self::ERROR_PASSWORD_INVALID;
            $this -> errorMessage = Yii::t("user", "Invalid login or password");
		} else if($user->isBlocked()) {
            $this -> errorCode = self::ERROR_USER_BLOCKED;
            $this -> errorMessage = Yii::t("user", "User has been blocked");
        } else {
            $this -> _id = $user -> id;
            $this -> username = $user -> profile -> full_name;
            $this -> errorCode = self::ERROR_NONE;
        }
		
		return $this -> errorCode == self::ERROR_NONE;
	}

	public function getId() {
		return $this -> _id;
	}
}