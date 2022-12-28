<?php
abstract class BaseController extends CController {
	protected $themeType;
	public $layout = '//layouts/column';
	public $title;

    abstract protected function setErrorHandlerAction();

	public function init() {
		$this -> setThemePath();
        $this -> setLanguage();
        $this->setErrorHandlerAction();
        $this->registerJsVariables();
	}

	public function setThemePath() {
		$tm = Yii::app() -> getThemeManager();
		if($tm -> hasBeenInitialized()) {
			return true;
		}
		$basePath = $tm -> getBasePath();
		$baseUrl = $tm -> getBaseUrl();
		$tm -> setBasePath($basePath. DIRECTORY_SEPARATOR. $this -> themeType);
		$tm -> setBaseUrl($baseUrl. '/'. $this -> themeType);
		Yii::app() -> theme = $tm -> getThemeDir($this -> themeType);
		$tm -> initialized();
	}

    public function setLanguage() {
        $langs = Yii::app() -> params['app.languages'];
        if (isset($_GET['language']) && isset($langs[$_GET['language']])) {
            $lang = $_GET['language'];
            Yii::app()->user->setState('language', $lang);
            $cookie = new CHttpCookie('language', $lang);
            $cookie->sameSite = Yii::app()->params['cookie.same_site'];
            $cookie->path = Yii::app()->params['app.base_url'];
            $cookie->secure = Yii::app()->params['cookie.secure'];
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::app()->request->cookies['language'] = $cookie;
        }
        elseif (isset(Yii::app()->request->cookies['language']))
            $lang = Yii::app()->request->cookies['language']->value;
        else
            $lang = mb_substr(Yii::app()->getRequest()->getPreferredLanguage(), 0, 2);

        if(!isset($langs[$lang])) {
            $lang = Yii::app() -> language;
        }
        Yii::app() -> language = $lang;
    }

    private function registerJsVariables() {
        $globalVars = CJSON::encode(array(
            'baseUrl'=> Yii::app()->request->getBaseUrl(true),
            'themeUrl'=>Yii::app() -> theme -> baseUrl,
            'proxyImage'=>(int) Yii::app()->params['thumbnail.proxy']
        ));
        Yii::app()->clientScript->registerScript('globalVars', "var _global = {$globalVars};", CClientScript::POS_HEAD);
    }

	public function getThemeUrl() {
		return Yii::app() -> getThemeManager() -> getBaseUrl() . '/'. Yii::app() -> theme -> name;
	}

	public function actionError() {
		if($error = Yii::app() -> errorHandler -> error) {
			if(Yii::app() -> request -> isAjaxRequest) {
				echo $error['message'];
			} else {
                switch($error['code']) {
                    case 404;
                        $this->title=$this->title=Yii::t("site", "Page not found: 404");
                    break;
                    case 500;
                        $this->title=$this->title=Yii::t("site", "Internal server error");
                    break;
                    case 400;
                        $this->title=$this->title=Yii::t("site", "Access denied");
                    break;
                    default:
                        $this->title=$error['code'];
                    break;
                }
                $this -> render("//site/error", $error);
			}
		}
	}

	public function actions() {
	    $actions = parent::actions();
	    Yii::app()->fc->instance()->appendAction($actions, 'captcha');
	    return $actions;
	}


    public function jsonResponse($response) {
        header('Content-type: application/json');
        echo json_encode($response);
        Yii::app() -> end();
    }
}