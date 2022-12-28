<?php
class CategoryController extends FrontController {
	public function actionIndex($path = null) {
		if(empty($path)) {
			$this -> processRoot();
		} else {
			$this -> processChildren($path);
		}
	}

	protected function processRoot() {
		$roots = Category::model() -> getRoots();
        $statistic = UrlCounter::model()->getStatForCat($roots);

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{BrandName}' => Yii::app() -> name,
			'{CategoryPath}' => Yii::t("site", "Categories"),
		);
		$this -> title = Yii::t("meta", "category title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "category keywords", $params), 'keywords');
		$cs -> registerMetaTag(Yii::t("meta", "category description", $params), 'description');

		$this -> render("roots", array(
            "roots" => $roots,
            "statistic" => $statistic,
		));
	}

	protected function processChildren($path) {
		$category = Category::model() -> findByPath($path);
		if($category == null) {
			throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
		}

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{BrandName}' => Yii::app() -> name,
			'{CategoryPath}' => $category -> formatRootPath(false, '&raquo;'),
		);
		$this->encodeTitle=false;
		$this -> title = Yii::t("meta", "category title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "category keywords", $params), 'keywords', null, array('encode' => false));
		$cs -> registerMetaTag(Yii::t("meta", "category description", $params), 'description', null, array('encode' => false));

		$children = $category -> cache(Yii::app()->params["params.cat_cache_time"]) -> children() -> findAll();
        $statistic = UrlCounter::model()->getStatForCat($children);

		$websites = array();
		$criteria = new CDbCriteria();
		$criteria -> select = "title, url, description, id";
		$criteria -> condition = 'category_id = :cid AND status = :status AND lang_id = :lang_id';
		$criteria -> params = array(':cid' => $category -> id, ':status' => Website::STATUS_APPROVED, ':lang_id' => Yii::app() -> language);
		$count = Website::model() -> count($criteria);

        $thumbnailStack = [];
		if($count > 0) {
			$pages = new CPagination($count);
			$pages -> pageSize = Yii::app() -> params["params.url_per_page"];
			$pages -> pageVar = 'page';
			$pages -> applyLimit($criteria);
			$websites = Website::model() -> findAll($criteria);
            $thumbnailStack = WebsiteThumbnail::thumbnailStack($websites);
		}

		$this -> render("children", array(
			'path' => $path,
			'category' => $category,
			'children' => $children,
			'count' => $count,
			'pages' => isset($pages) ? $pages : null,
			'websites' => $websites,
            'statistic' => $statistic,
            'thumbnailStack'=>$thumbnailStack,
		));
	}

	public function actionSuggest($id = null) {
		$category = Category::model() -> findByPk($id);
		if($category == null) {
			throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists")) ;
		}

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{CategoryPath}' => $category -> formatRootPath(false, '&raquo;'),
		);
		$this -> title = Yii::t("meta", "suggest category title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "suggest category keywords", $params), 'keywords', null, array('encode' => false));
		$cs -> registerMetaTag(Yii::t("meta", "suggest category description", $params), 'description', null, array('encode' => false));

		$suggest = new Suggest();
		$suggest -> category_id = $category -> id;

		if(Yii::app() -> request -> isPostRequest && !empty($_POST['Suggest'])) {
			$suggest -> attributes = $_POST['Suggest'];
			if($suggest -> save()) {
				Yii::app() -> user -> setFlash('success', Yii::t("category", "The category has been succesfully suggested"));
				$this -> refresh();
			}
		}

		$this -> render("suggest_category", array(
			"category" => $category,
			"suggest" => $suggest,
		));

	}
}