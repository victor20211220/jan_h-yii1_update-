<?php
class FlexibleCaptchaComponent extends CComponent
{
    public $tmplPath;

    /**
     * @var IFlexibleCaptcha | null
     */
    private $captcha;

    public function init() {
        Yii::import('application.components.flexible_captcha.*');
    }

    /**
     * @return IFlexibleCaptcha
     */
    public function instance() {
        if(!$this->captcha) {
            $this->captcha = $this->create();
        }
        return $this->captcha;
    }

    /**
     * @return IFlexibleCaptcha
     */
    public function create() {
        //return $this->createRecaptcha();
        //return $this->createImageCaptcha();
        //return $this->createNoCaptcha();

        if(Yii::app()->params['app.captcha']) {
            if(Helper::isRecaptchaEnabled()) {
                return $this->createRecaptcha();
            } else {
                $img = $this->createImageCaptcha();
                return $img->isAllowed() ? $img : $this->createNoCaptcha();
            }
        } else {
            return $this->createNoCaptcha();
        }
    }

    public function createRecaptcha() {
        $captcha = new FlexibleCaptchaRecaptcha(array(
            'public-key'=>Yii::app()->params['recaptcha.public'],
            'private-key'=>Yii::app()->params['recaptcha.private'],
            'theme'=>Yii::app()->params['recaptcha.theme'],
        ));
        $this->buildCaptcha($captcha);
        return $captcha;
    }

    public function createNoCaptcha()
    {
        return new FlexibleCaptchaBlank();
    }

    public function createImageCaptcha() {
        $captcha = new FlexibleCaptchaImage();
        $this->buildCaptcha($captcha);
        return $captcha;
    }

    private function buildCaptcha(FlexibleCaptchaAbstractBase $captcha) {
        $captcha->registerClassMap();
        $captcha->setSystemView(dirname(__FILE__).'/views/');
        $captcha->setUserViews($this->tmplPath);
    }
}