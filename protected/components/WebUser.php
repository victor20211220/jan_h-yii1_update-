<?php
class WebUser extends CWebUser {
    protected $_allowed = array(
        'admin_site_index', 'admin_auth_login', 'admin_auth_logout', 'admin_url_existdofollowlink'
    );
    protected $_model;
    protected $_assignments;

	public function isSuperUser() {
		return $this->loadModel()->isSuperUser();
	}

    public function appendFlash($type, $message, $break = '<br/>') {
        $m = $this->getFlash($type);
        !empty($m) ? $this->setFlash($type, $m.$break.$message) : $this->setFlash($type, $message);
    }

    public function loadModel() {
        if(empty($this->_model)) {
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    public function loadAssignments() {
        if(empty($this->_assignments)) {
            $auth = Yii::app() -> authManager;
            $this->_assignments = $auth->getAuthAssignments($this->id);
        }
        return $this->_assignments;
    }

    public function checkAccess($operation, $params = array(), $allowCaching = true) {
        if($this->isSuperUser()) {
            return true;
        }
        if(in_array($operation, $this->_allowed)) {
            return true;
        }
        $assignments = $this->loadAssignments();
        return isset($assignments[$operation]);
    }

    public function allowedGroup($pattern) {
        if($this->isSuperUser()) {
            return true;
        }
        $assignments = $this->loadAssignments();
        $keys = array_keys($assignments);
        $pattern = "#^{$pattern}.*#";
        $matches = preg_grep($pattern, $keys);
        return !empty($matches);
    }

}