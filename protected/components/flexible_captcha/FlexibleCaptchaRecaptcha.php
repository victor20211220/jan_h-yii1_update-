<?php
class FlexibleCaptchaRecaptcha extends FlexibleCaptchaAbstractBase
{
    private $conf;

    public function __construct($conf)
    {
        $this->conf = $conf;
    }

    protected function registerClassMapOnce()
    {
        Yii::$classMap = array_merge( Yii::$classMap, array(
            'ReCaptcha2Validator' => Yii::getPathOfAlias('ext.recaptcha2').DIRECTORY_SEPARATOR.'ReCaptcha2Validator.php',
            'ReCaptcha2Widget' => Yii::getPathOfAlias('ext.recaptcha2').DIRECTORY_SEPARATOR.'ReCaptcha2Widget.php'
        ));
    }

    public function appendAction(array &$actions, $key) {}

    protected function getShortName()
    {
        return "recaptcha";
    }

    public function getModelLabelText()
    {
        return '';
    }

    public function getValidationClassName()
    {
        return 'ReCaptcha2Validator';
    }

    public function appendValidationRule(array & $rules, array $additional = array())
    {
        parent::appendValidationRule($rules, array_merge(
            $additional,
            array(
                'privateKey'=>$this->conf['private-key'],
                'message'=>Yii::t("site", "Please confirm you're not a robot")
            )
        ));
    }

    protected function getAdditionalViewParams()
    {
        return array(
            "conf"=>$this->conf,
        );
    }

    public function isAllowed()
    {
        return Helper::isRecaptchaEnabled();
    }
}