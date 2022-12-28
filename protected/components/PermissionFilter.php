<?php
class PermissionFilter extends CFilter {

    public $loginUrl=array('admin/auth/login');
    public $allowedController = 'admin/auth';

	protected function preFilter($filterChain) {
        $controller = Yii::app()->controller;
        $user = Yii::app() -> getUser();
        $action = Yii::app()->controller->action;
        $controllerID = $controller->getId();
        $actionID = $action->getId();
        $operation = sprintf("%s_%s", str_replace("/", "_", $controllerID), $actionID);

        if($user->isGuest) {
            if($controllerID != $this->allowedController) {
                $user->returnUrl = Yii::app()->request->url;
                if(Yii::app()->request->isAjaxRequest) {
									throw new CHttpException(400, Yii::t("yii", "You are not authorized to perform this action."));
                } else {
									$controller->redirect($this->loginUrl);
                }
            } else {
                return true;
            }
        }

        if($user -> isSuperUser()) {
            return true;
        }

        if(!$user->checkAccess($operation)) {
            throw new CHttpException(400, Yii::t("error", "You don't have permissions to access this page"));
        }
        return true;
	}
}