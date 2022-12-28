<?php
Yii::import("ext.ecountrylist.ECountryList");
Yii::import("ext.ealphabet.EAlphabet");

class CountryController extends FrontController {
	public function actionLetters($letter) {
		$countries = ECountryList::getInstance(Yii::app() -> language) -> getCountriesStartingWithLetter($letter);
		$a = EAlphabet::getInstance(Yii::app() -> language);
		$letters = $a->getAlphabetAsArray();
		$letter = $a->issetLetter($letter) ? $letter : $a->getFirstLetter();

		$this->title = Yii::t("site", "Countries on {Letter} letter", array(
			"{Letter}"=>mb_strtoupper($letter),
		));
		$cs = Yii::app()->clientScript;
		$cs -> registerMetaTag($this->title, 'description');

		$statistic = Website::getStatisticByCountries(array_keys($countries));

		$this->render("country_by_letter", array(
			"countries"=>$countries,
			"statistic"=>$statistic,
			"letters"=>$letters,
			"letter"=>$letter,
		));
	}

	public function actionUrl($country) {
		if(!$country_id = ECountryList::getInstance(Yii::app() -> language) -> getCountryIdByName($country)) {
			throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
		}

		$websites = array();
		$criteria = new CDbCriteria();
		$criteria -> select = "title, url, description, id";
		$criteria -> condition = 'country_id = :cid AND status = :status AND lang_id = :lang_id';
		$criteria -> params = array(':cid' => $country_id, ':status' => Website::STATUS_APPROVED, ':lang_id' => Yii::app() -> language);
		$count = Website::model() -> count($criteria);

		$this->title = Yii::t("site", "Websites in {Country}", array(
			"{Country}"=>Helper::mb_ucfirst($country),
		));
		$cs = Yii::app()->clientScript;
		$cs -> registerMetaTag($this->title, 'description');

        $thumbnailStack = [];
		if($count > 0) {
			$pages = new CPagination($count);
			$pages -> pageSize = Yii::app() -> params["params.country_url_per_page"];
			$pages -> pageVar = 'page';
			$pages -> applyLimit($criteria);
			$criteria -> order = 'created_at DESC';
			$websites = Website::model() -> findAll($criteria);
            $thumbnailStack = WebsiteThumbnail::thumbnailStack($websites);
		}

		$this->render("website_by_country", array(
			"websites" => $websites,
			"count" => $count,
			"pages" => isset($pages) ? $pages : null,
            "thumbnailStack"=>$thumbnailStack
		));
	}
}