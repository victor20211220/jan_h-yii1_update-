<?php
class SystemLogController extends BackController {

	public function actionIndex() {
		$model = new SystemLog;
		$this -> title = Yii::t("system_log", "System log");

		$provider = new CActiveDataProvider($model, array(
			'criteria' => array(
				'condition'=>'t.visible=:visible',
				'params'=>array(':visible'=>SystemLog::VISIBLE),
				'order'=>'t.created_at DESC',
				'with' => array(
					'profile' => array(
						'select' => 'full_name',
					),
					'together' => false,
				),
			),
			'pagination' => array(
				'pageSize' => Yii::app() -> params['params.admin_log'],
			),
		));

		$this -> render("//system_log/index", array(
			'provider' => $provider,
			'model' => $model,
		));
	}

    public function actionRemove() {
        $type = Yii::app()->request->getQuery('type');
        $method = "systemlog$type";
        if(method_exists($this, $method)) {
            $this -> $method();
        }
    }

    protected function systemLogTruncate() {
		SystemLog::model() -> truncateTable();
		Yii::app() -> user -> setFlash("success", Yii::t("system_log", "All systems log has been removed"));
		$this ->redirect(Yii::app() -> request -> urlReferrer);
	}

	protected function systemLogDelete() {
		if(!isset($_POST['ids']) OR !is_array($_POST['ids'])) {
			$this ->redirect(Yii::app() -> request -> urlReferrer);
		}
		$criteria = new CDbCriteria;
		$criteria -> addInCondition('id', $_POST['ids']);
		SystemLog::model() -> deleteAll($criteria);
		Yii::app() -> user -> setFlash("success", Yii::t("system_log", "Selected logs has been removed"));
        $this ->redirect(Yii::app() -> request -> urlReferrer);
	}

}