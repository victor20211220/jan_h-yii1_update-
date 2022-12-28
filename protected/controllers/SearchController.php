<?php

class SearchController extends FrontController {
	public function actionIndex() {
		$q = trim(Yii::app() -> request -> getQuery('q'));

		$cs = Yii::app() -> clientScript;
		$params = array('{QueryString}' => $q);
		$this -> title = Yii::t("meta", "search page title", $params);

		if(mb_strlen($q) < Yii::app() -> params["params.url_search_min_length"]) {
			$html = $this -> renderPartial("not_found", array(
				'message' => Yii::t("site", "Too short query string", array('{Length}' => Yii::app() -> params["params.url_search_min_length"])),
			), true);
			$this->title = Yii::t("site", "Short query string");
		} else {
			$criteria = new CDbCriteria();
			$criteria -> select = "title, url, description, id";
			$criteria -> condition = "MATCH (description, url) AGAINST (:q IN BOOLEAN MODE) AND Status=:approved";
			$criteria -> params = array(':q' => $q, ':approved'=>Website::STATUS_APPROVED);
			$count = Website::model()->count($criteria);

			if($count > 0) {
				$pages = new CPagination($count);
				$pages -> pageSize = Yii::app() -> params["params.search_url_per_page"];
				$pages -> applyLimit($criteria);
				$results = Website::model() -> findAll($criteria);
				$thumbnailStack = WebsiteThumbnail::thumbnailStack($results);
				$html = $this -> renderPartial("result", array(
					'pages' => $pages,
					'results' => $results,
                    'thumbnailStack'=>$thumbnailStack,
				), true);
				$this -> title = Yii::t("site", "Search result");
			} else {
				$this -> title = Yii::t("site", "Not found");
				$html = $this -> renderPartial("not_found", array(
					'message' => Yii::t("site", "Nothing found for: {Query}", array('{Query}' => CHtml::encode($q))),
				), true);
			}
		}

		$this -> render("index", array(
			'html' => $html,
		));
	}

	public function actionCategory() {
		$q = trim(Yii::app() -> request -> getQuery('q'));
		$cs = Yii::app() -> clientScript;
		$params = array('{QueryString}' => $q);
		$this -> title = Yii::t("meta", "search page title", $params);
		$html = '';

        if(mb_strlen($q) < Yii::app() -> params["params.cat_search_min_length"]) {
            $html = $this -> renderPartial("not_found", array(
                'message' => Yii::t("site", "Too short query string", array('{Length}' => Yii::app() -> params["params.cat_search_min_length"])),
            ), true);
            $this->title = Yii::t("site", "Short query string");
        } else {
            $criteria = new CDbCriteria();
            $criteria -> condition = "lang_id=:lang_id AND slug LIKE :slug";
            $criteria -> params = array(
                ":lang_id" => Yii::app()->language,
                ":slug" => "%".addcslashes($q, '%_')."%",
            );
            $count = Category::model()->count($criteria);

            if($count > 0) {
                $pages = new CPagination($count);
                $pages -> pageSize = Yii::app() -> params["params.search_cat_per_page"];
                $pages -> applyLimit($criteria);
                $results = Category::model() -> findAll($criteria);
                $html = $this -> renderPartial("category_result", array(
                    'pages' => $pages,
                    'results' => $results,
                ), true);
            } else {
                $this -> title = Yii::t("site", "Not found");
                $html = $this -> renderPartial("not_found", array(
                    'message' => Yii::t("site", "Nothing found for: {Query}", array('{Query}' => CHtml::encode($q))),
                ), true);
            }
        }

		$this -> render("category", array(
			"html" => $html,
		));
	}

}