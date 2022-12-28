<?php
class FlexibleCaptchaImage extends FlexibleCaptchaAbstractBase {
    private static $is_allowed;

    public function appendAction(array &$actions, $key)
    {
        if($this->isAllowed()) {
            $actions[$key] = array(
                'class'=>'CaptchaExtendedAction',
                'mode'=>CaptchaExtendedAction::MODE_DEFAULT,
            );
        }
    }

    protected function registerClassMapOnce()
    {
        Yii::$classMap = array_merge( Yii::$classMap, array(
            'CaptchaExtendedAction' => Yii::getPathOfAlias('ext.captchaExtended').DIRECTORY_SEPARATOR.'CaptchaExtendedAction.php',
            'CaptchaExtendedValidator' => Yii::getPathOfAlias('ext.captchaExtended').DIRECTORY_SEPARATOR.'CaptchaExtendedValidator.php'
        ));
    }


    protected function getShortName()
    {
        return 'image';
    }

    public function getModelLabelText()
    {
        return Yii::t("site", "Verification code");
    }

    public function getValidationClassName()
    {
        return 'CaptchaExtendedValidator';
    }


    public function isAllowed()
    {
        if(!is_null(self::$is_allowed)) {
            return self::$is_allowed;
        }
        if(!extension_loaded('gd')) {
            self::$is_allowed =  false;
        } else {
            $gd_info = gd_info();
            if(!$gd_info['FreeType Support']) {
                self::$is_allowed = false;
            } else {
                self::$is_allowed = true;
            }
        }
        return self::$is_allowed;
    }
}