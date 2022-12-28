<?php
class SiteController extends FrontController {

	public function actionIndex() {
		$popular = Website::model()->popular(Yii::app() -> params['params.top_listing'])->findAll();
		$newest = Website::model() -> recentlyApproved(Yii::app() -> params['params.new_listing'])->findAll();

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{BrandName}' => Yii::app() -> name,
		);

		$this -> title = Yii::t("meta", "index page title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "index page keywords", $params), 'keywords');
		$cs -> registerMetaTag(Yii::t("meta", "index page description", $params), 'description');

		$this -> render("index", array(
			'popular' => $popular,
			'newest' => $newest,
		));
	}

	public function actionContact() {
		$model = new ContactForm;
		$this -> title = Yii::t("contact", "Contact us");

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{BrandName}' => Yii::app() -> name,
		);
		$this -> title = Yii::t("meta", "contact page title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "contact page keywords", $params), 'keywords');
		$cs -> registerMetaTag(Yii::t("meta", "contact page description", $params), 'description');


		if(isset($_POST['ContactForm'])) {
			$model->attributes=$_POST['ContactForm'];
			if($model->validate()) {
				try {
                    $mailer = new YiiMailer();

                    $mailer->clearAddresses();
                    $mailer->clearReplyTos();
                    $mailer->setSubject($model -> subject);
                    $mailer->setFrom(Yii::app() -> params['notification.email'], Yii::app()->name);
                    $mailer->addReplyTo($model->email, $model->name);
                    $mailer->addAddress(Yii::app() -> params["contact.email"]);
                    $mailer->setBody(nl2br($model -> body));
                    $mailer->setAltText($model -> body);
                    $mailer->send();

					Yii::app() -> user -> setFlash('success', Yii::t("email", "Email has been sent"));
				} catch (Exception $e) {
					Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
					Yii::app() -> user -> setFlash('warning', Yii::t("email", "An error occurred while sending email"));
				}
				$this -> refresh();
			}
		}

		$this -> render("contact", array(
			'model' => $model,
		));
	}

    public function actionBanners() {
        $this->title=Yii::t("site", "Banners to link to {BrandName}", array(
            "{BrandName}"=>Yii::app()->name,
        ));
        $banners=Helper::getBannerList();
        $this->render("banners", array(
            "banners"=>$banners,
        ));
    }
}