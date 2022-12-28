<?php
class ConsoleUser extends CApplicationComponent implements IWebUser{
    public $admin;
    public $allowAutoLogin=false;
    public $loginUrl;

    public function init() {
        parent::init();
        if(!$this->admin=User::model()->admin()->find()) {
            throw new Exception('Could not find Admin User to execute console application.');
        }
    }
    public function getId() {
        return $this->admin->id;
    }
    public function getName() {
        return $this->admin->profile->full_name;
    }
    public function getIsGuest() {
        return false;
    }
    public function checkAccess($operation,$params=array()) {
        return true;
    }
    public function loginRequired() {}
}