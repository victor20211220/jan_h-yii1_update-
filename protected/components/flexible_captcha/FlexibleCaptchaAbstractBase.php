<?php


abstract class FlexibleCaptchaAbstractBase implements IFlexibleCaptcha
{
    private $userViews;
    private $systemViews;
    private static $registeredClassMap = false;
    protected $defaultViewParams = array(
        'attribute'=>'verifyCode',
    );

    abstract protected function getShortName();
    abstract public function getModelLabelText();
    abstract public function getValidationClassName();

    abstract protected function registerClassMapOnce();

    public function registerClassMap()
    {
        if(!self::$registeredClassMap) {
            $this->registerClassMapOnce();
            self::$registeredClassMap = true;
        }
    }

    public function setUserViews($path) {
        $this->userViews = rtrim($path, "/");
    }

    public function setSystemView($path) {
        $this->systemViews = rtrim($path, "/");
    }

    public function render(array $params = array(), $view = null)
    {
        $buffer = null;
        $userView = $this->getUserViewPath($view);
        $systemView = $this->getSystemViewPath();
        $params = array_merge($this->defaultViewParams, $params, array(
            "isAllowed"=>$this->isAllowed(),
            "params"=>$this->getAdditionalViewParams(),
        ));
        if($view === null) {
            return Yii::app()->controller->renderFile($systemView, $params, true);
        } else {
            $buffer = null;
            try {
                $buffer = Yii::app()->controller->renderPartial($userView, $params, true);
            } catch (CException $exception) {
                try {
                    $buffer = Yii::app()->controller->renderFile($systemView, $params, true);
                } catch (CException $exception) {
                    throw new CException("Unable to find view: [{$userView}], [{$systemView}]");
                }
            }
            return $buffer;
        }
    }

    public function appendValidationRule(array &$rules, array $additional = array())
    {
        if($this->isAllowed()) {
            $rule = array_merge(
                array($this->defaultViewParams['attribute'], $this->getValidationClassName()),
                $additional
            );
            $rules[] = $rule;
        }
    }

    private function getSystemViewPath() {
        return $this->systemViews."/".$this->getShortName().".php";
    }

    private function getUserViewPath($view = null) {
        return $this->userViews."/".$this->getShortName(). (!empty($view) ? "_".$view : null);
    }

    protected function getAdditionalViewParams() {
        return array();
    }
}