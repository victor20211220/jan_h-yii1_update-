<?php
class BackController extends BaseController {
	protected $themeType = "admin";

    protected function setErrorHandlerAction()
    {
        Yii::app()->errorHandler->errorAction='admin/site/error';
    }


    public function filters() {
		return array(
			array(
				'application.components.PermissionFilter',
                'loginUrl' => array('admin/auth/login'),
                'allowedController' => 'admin/auth',
			),
		);
	}
}