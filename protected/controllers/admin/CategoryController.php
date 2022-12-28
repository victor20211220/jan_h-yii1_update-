<?php
class CategoryController extends BackController {

	public function actionRoots() {
        $this -> title = Yii::t("category", "Manage roots");
		$criteria = new CDbCriteria;
		$criteria -> select = 'title, lang_id, id';
		$criteria -> addInCondition('lang_id', array_keys(Yii::app()->params['app.languages']));
		$roots = Category::model() -> roots() -> findAll($criteria);

		$create = Yii::app() -> params["app.languages"];
		foreach($roots as $root) {
			unset($create[$root -> lang_id]);
		}

		$this -> render("//category/roots", array(
			"roots" => $roots,
			"create" => $create,
		));
	}

	public function actionCreateRoot() {
		if(!isset($_POST['lang_id'])) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$temp_lang = Yii::app() -> language;
		Yii::app() -> language = $temp_lang;
		$category = new Category();
		$category -> scenario = "root";
		$category -> title = $category -> slug = Yii::app() -> params["app.languages"][$_POST['lang_id']];
		$category -> lang_id = $_POST['lang_id'];

		if($category -> saveNode()) {

			$log = new SystemLog();
			$log -> module = "Category module";
			$log -> log = "{User} has created root ({LangID}) category";
			$log -> params = array("{LangID}" => $_POST['lang_id']);
			$log -> save();

			Yii::app() -> user -> setFlash('success', Yii::t("category", "Category has been created"));
		} else {
			Yii::app() -> user -> setFlash('danger', Yii::t("category", "An error has been occurred during category creating"));
		}
		$this ->redirect(Yii::app() -> request -> urlReferrer);
	}

	public function actionUpdate() {
		//$_POST['id'] = 5;
		//$_POST['Category']['title'] = 'Fruits';
		//$_POST['Category']['slug'] = 'fruits123';
		//$_POST['Category']['visible'] = '1';
		//$_POST['pid'] = 2;

		//$this -> jsonResponse($_POST);

		if(!isset($_POST['id']) AND !isset($_POST['pid']) AND !isset($_POST['Category'])) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$node = Category::model() -> findByPk($_POST['id']);
		$parent = Category::model() -> findByPk($_POST['pid']);

		if($node == null || $parent == null) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$node -> attributes = $_POST['Category'];
		$node -> parentNode = $parent;

		//var_dump($node -> validate());
		//die();

		if($node -> saveNode()) {
			$response = array(
				"title" => $node -> title,
				"slug" => $node -> slug,
				"success" => array(Yii::t("category", "Category {ID} has been successfully updated", array(
					"{ID}" => sprintf("<strong>%s</strong>", $node -> id),
				))),
			);

			$log = new SystemLog();
			$log -> module = "Category module";
			$log -> log = "{User} has updated category {Category}";
			$log -> params = array("{Category}" => $node -> formatRootPath(true));
			$log -> save();

		} else {
			$response = array(
				"error" => $node -> getErrors(),
			);
		}
		$this -> jsonResponse($response);
	}

	public function actionCreate() {
		/*$_POST['pid'] = 1;
		$_POST['Category']['title'] = 'House';
		$_POST['Category']['lang_id'] = 'en';
		$_POST['Category']['slug'] = 'house';*/

		if(!isset($_POST['Category']) AND !isset($_POST['pid'])) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$parent = Category::model() -> findByPk($_POST['pid']);
		if($parent == null) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$category = new Category();
		$category -> scenario = 'create';
		$category -> parentNode = $parent;
		$category -> attributes = (array) $_POST['Category'];

		if($category -> prependTo($parent)) {
			$response = array(
				"id" => $category -> id,
				"title" => $category -> title,
				"slug" => $category -> slug,
				"success" => array(Yii::t("category", "Category {Category} has been successfully added", array(
					"{Category}" => sprintf("<strong>%s</strong>", $category -> title),
				))),
			);

			$log = new SystemLog();
			$log -> module = "Category module";
			$log -> log = "{User} has created category {Category}";
			$log -> params = array("{Category}" => $category -> formatRootPath(true));
			$log -> save();

		} else {
			$response = array(
				"error" => $category -> getErrors(),
			);
		}
		$this -> jsonResponse($response);
	}

	public function actionRemove() {
		if(!$id = (int) Yii::app() -> request -> getPost("id")) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		if(!$category = Category::model() -> findByPk($id)) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

        if($category -> isRoot()) {
            throw new CHttpException(400, Yii::t("category", "Can't remove root category"));
        }

		if(!$category -> isLeaf()) {
			throw new CHttpException(400, Yii::t("category", "Can't remove not empty category"));
		}

		if(Website::model() -> countByAttributes(array("category_id" => $category -> id))) {
			throw new CHttpException(400, Yii::t("category", "Can't remove category which contains websites"));
		}

		$title = trim(Yii::app() -> request -> getPost("title"));

		$path = $category -> formatRootPath(true);

		if($category -> deleteNode()) {
			$response = array("success" => Yii::t("category", "Category {Category} has been removed", array(
				"{Category}" => sprintf("<strong>%s</strong>", $title),
			)));

			$log = new SystemLog();
			$log -> module = "Category module";
			$log -> log = "{User} has removed category {Category}";
			$log -> params = array("{Category}" => $path);
			$log -> save();

		} else {
			$response = array("error" => Yii::t("error", "An error occurred while removing record"));
		}

		$this -> jsonResponse($response);
	}

	public function actionMove() {
		$node_id = (int) Yii::app() -> request -> getPost("node_id");
		$parent_id = (int) Yii::app() -> request -> getPost("parent_id");
		$previous_id = (int) Yii::app() -> request -> getPost("previous_id");
		$error = false;

		if($node_id < 2 AND $parent_id < 1) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		if(!$node = Category::model() -> findByPk($node_id)) {
			$this -> jsonResponse(array("error" => Yii::t("category", "Cannot find node with specified ID {ID}", array(
				"{ID}" => $node_id
			))));
		}

		if(!$parent = Category::model() -> findByPk($parent_id)) {
			$this -> jsonResponse(array("error" => Yii::t("category", "Cannot find node with specified ID {ID}", array(
				"{ID}" => $node_id
			))));
		}

		$oldpath = $node -> formatRootPath(true);
		$node -> parentNode = $parent;

		if(!$node -> validate()) {
			$this -> jsonResponse(array("error" => $node -> getErrors()));
		}

		if($previous_id > 0) {
			if(!$previous = Category::model() -> findByPk($previous_id)) {
				$this -> jsonResponse(array("error" => Yii::t("category", "Cannot find node with specified ID {ID}", array(
					"{Nr}" => $previous_id,
				))));
			}

			if($node -> moveBefore($previous)) {
				$response = array("success" => Yii::t("category", "Category {Category} has been successfully moved", array(
					"{Category}" => sprintf("<strong>%s</strong>", $node -> title),
				)));
			} else {
				$error = true;
			}
		} else {
			if($node -> moveAsLast($parent)) {
				$response = array("success" => Yii::t("category", "Category {Category} has been successfully moved", array(
					"{Category}" => sprintf("<strong>%s</strong>", $node -> title),
				)));
			} else {
				$error = true;
			}
		}

		if(!$error) {
			$log = new SystemLog();
			$log -> module = "Category module";
			$log -> log = "{User} has changed category {OldPath} path. New path is {NewPath}";
			$log -> params = array("{OldPath}" => $oldpath, "{NewPath}" => $node -> formatRootPath(true));
			$log -> save();
			$this -> jsonResponse($response);
		} else {
			$this -> jsonResponse(array("error" => Yii::t("category", "An error has been occurred during category moving")));
		}
	}

    public function actionManage($id) {
        $root = Category::model() -> findByPk($id);
        if($root == null) {
            throw new CHttpException(400, Yii::t("error", "Bad request"));
        }

        $this -> title = Yii::t("category", "Manage root ({Root}) category", array("{Root}" => $root -> lang_id));

        $cs = Yii::app()->clientScript;
        $cs -> registerScriptFile(Yii::app()->theme->baseUrl.'/js/jstree/jquery.jstree.js');
        $cs -> registerCssFile(Yii::app()->theme->baseUrl . '/css/tree_component.css');

        $this -> render("//category/index", array(
            "root" => $root,
        ));
    }

    public function actionNode() {
        $parent_id = isset($_GET['pid']) ? (int)$_GET['pid'] : false;
        $attrs = array(
            'lang_id' => Yii::app() -> request -> getQuery("lang_id", Yii::app() -> language),
        );

        if($parent_id) {
            $category = Category::model() -> findByPk($parent_id);
            $roots = $category -> children() -> findAllByAttributes($attrs);
        } else {
            $roots=Category::model() -> roots() -> findAllByAttributes($attrs);
        }

        $data = array();
        $i = 0;
        foreach($roots as $root) {
            $state = !$root -> isLeaf() ? "closed" : "";
            $data[$i]["data"] = CHtml::encode($root -> title);
            $data[$i]["metadata"] = array(
                'id' => $root -> id,
                'title' => CHtml::encode($root -> title),
                'slug' => CHtml::encode($root -> slug),
            );
            $data[$i]["attr"] = array(
                "state" => $state,
                "rel" => "folder",
            );
            $data[$i]["state"] = $state;
            $i++;
        }

        $this -> jsonResponse($data);
    }

	public function actionDropdownCategory() {
		//$_POST['id'] = 9;

		if(!isset($_POST['id'])) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}
		$id = $_POST['id'];
		$category = Category::model() -> findByPk($id);
		if($category == null) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$children = $category -> children() -> findAll();
		$website = new Website();

		if(empty($children)) {
			echo CHtml::activeHiddenField($website, 'category_id', array('value'=>$id));
			return true;
		}

		$phrase = Yii::t("website", "Leave website in {Category} category", array(
			'{Category}' => $category -> title,
		));
		$subcats = $category -> level > 1 ?
		CMap::mergeArray(array($category -> id => $phrase , '-' => '----------'), CHtml::listData($children, 'id', 'title')) :
		CHtml::listData($children, 'id', 'title');

		echo CHtml::activeDropDownList($website, 'category_id', $subcats,
		 	array(
				//'prompt'=>Yii::t("category", "Choose subcategory"),
                'class' => 'form-control',
				'onchange'=> '
					var attr = $("option:selected", this).attr("readonly");
					if(attr == "readonly") {
						return false;
					}
				'
				.CHtml::ajax(array(
					'type'=>'POST',
					'url'=> $this -> createUrl('admin/category/dropdowncategory'),
					'data' => array('id' => 'js:$(this).val()'),
					'update'=> '#subcat_'. $category -> level,
				)),
				'options' => array(
					'-' => array(
						'disabled' => 'disabled',
					),
					$category -> id => array(
						'readonly' => 'readonly',
					),
				),
			)
		);
		echo '<div id="subcat_'.$category -> level.'"></div>';
	}

	public function actionSuggest() {
        $this -> title = Yii::t("category", "Suggestions");
		$dataProvider = new CActiveDataProvider('Suggest', array(
			'criteria'=>array(
				'order'=>'created_at ASC',
			),
			'pagination'=>array(
				'pageSize' => Yii::app() -> params["params.admin_suggest"],
				'pageVar' => 'page',
			),
		));
		$this -> render("//category/suggest", array(
			"dataProvider" => $dataProvider,
		));
	}

    public function actionDeleteSuggest() {
        $type = Yii::app()->request->getQuery('type');
        $method = "suggest$type";
        if(method_exists($this, $method)) {
            $this -> $method();
        }
    }

	protected function suggestTruncate() {
		Suggest::model() -> truncateTable();
		Yii::app() -> user -> setFlash("success", Yii::t("system_log", "All suggestions has been removed"));
		$log = new SystemLog();
		$log -> module = "Category module";
		$log -> log = "{User} has removed all suggestions";
		$log -> save();
		$this ->redirect(Yii::app() -> request -> urlReferrer);
	}

    protected function suggestRemove() {
		if(!isset($_POST['ids']) OR !is_array($_POST['ids'])) {
			$this ->redirect(Yii::app() -> request -> urlReferrer);
		}

		$criteria = new CDbCriteria;
		$criteria -> addInCondition('id', $_POST['ids']);

		if($removed = Suggest::model() -> deleteAll($criteria)) {
			$log = new SystemLog();
			$log -> module = "Category module";
			$log -> log = "{User} has removed {Count} suggestion(-s)";
			$log -> params = array('{Count}' => $removed);
			$log -> save();
			Yii::app() -> user -> setFlash('success', Yii::t("system_log", "Selected suggestions has been removed"));
		}
		$this ->redirect(Yii::app() -> request -> urlReferrer);
	}
}