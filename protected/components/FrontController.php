<?php
class FrontController extends BaseController {
	protected $themeType = "public";
    public $encodeTitle=true;

    protected function setErrorHandlerAction()
    {
        Yii::app()->errorHandler->errorAction='site/error';
    }


    public function init() {
        parent::init();
        $this->registerCookieDisclaimer();
    }

    private function registerCookieDisclaimer() {

        if(Yii::app()->request->isAjaxRequest OR !Yii::app()->params['cookie_law.show']) {
            return true;
        }

        /**
         * @var $cs CClientScript
         */
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile(Yii::app()->theme->baseUrl."/js/cookieconsent.latest.min.js", CClientScript::POS_END);
        $path = Yii::app()->params['app.base_url'].";SameSite=".Yii::app()->params['cookie.same_site'];
        if(Yii::app()->params['cookie.secure']) {
            $path .= ";secure";
        }
        $cs->registerScript("cookieconsent", "
			window.cookieconsent_options = {
				learnMore: ".CJavaScript::encode(Yii::t("site", "Learn more")).",
				dismiss: ". CJavaScript::encode(Yii::t("site", "OK")).",
				message: ". CJavaScript::encode(Yii::t("site", "This website uses cookies to ensure you get the best experience on our website.")).",
				theme:". CJavaScript::encode(Yii::app()->params['cookie_law.theme']).",
				link: ". CJavaScript::encode(strtr(Yii::app()->params['cookie_law.link'], array('{language}'=>Yii::app()->language))).",
				path: ". CJavaScript::encode($path).",
				expiryDays: ". CJavaScript::encode(Yii::app()->params['cookie_law.expiry_days'])."
			};
		", CClientScript::POS_HEAD);
        $cs->registerCss("hide_cookie_law_logo", "
            .cc_logo { display: none !important; }
        ");
        return true;
    }
}