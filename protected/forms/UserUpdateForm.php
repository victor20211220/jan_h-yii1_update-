<?php
class UserUpdateForm extends CFormModel {
    public $login, $full_name, $email, $owner_id;

    public function rules() {
        return array(
            array('login, full_name, email', 'required'),
            array('login', 'length', 'min' => 4),
            array('full_name', 'length', 'max' => 80),
            array('login', 'length', 'max' => 50),
            array('email', 'email'),
            array('login', 'userExists'),
        );
    }

    public function userExists() {
        if(!$this->hasErrors()) {
            $criteria = new CDbCriteria();
            $criteria -> select = '1';
            $criteria -> condition = '(login = :login) and (id != :id)';
            $criteria -> params = array('login' => $this -> login, ':id' => $this -> owner_id);
            $criteria -> limit = 1;
            if(User::model() -> count($criteria)) {
                $this -> addError("login", Yii::t("user", "{Login} already exists", array(
                    "{Login}" => $this -> login,
                )));
            }
        }
    }
    public function attributeLabels() {
        return array(
            'login' => Yii::t("user", "Login"),
            'full_name' => Yii::t("user", "Full Name"),
            'email' => Yii::t("user", "Email"),
        );
    }
}