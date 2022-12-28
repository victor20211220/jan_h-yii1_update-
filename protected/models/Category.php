<?php
class Category extends CActiveRecord {
	public $parentNode;
	public $parents;

    /**
     * @param string $className
     * @return Category
     */
    public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{category}}';
	}

    public function behaviors() {
		return array(
			'NestedSetBehavior'=>array(
				'class'=>'ext.nestedset.NestedSetBehavior',
				'hasManyRoots' => true,
			),
		);
	}

	public function relations() {
		return array(
			'website' => array(self::HAS_MANY, 'Website', 'category_id'),
		);
	}

	public function rules() {
		return array(
			array('title, lang_id, slug', 'required'),
			array('title', 'length', 'max' => 50),
			array('slug', 'filter', 'filter' => array($obj = new Helper(), 'slug')),
			array('slug', 'length', 'max' => 50),
			array('lang_id', 'in', 'range' => array_keys(Yii::app() -> params["app.languages"])),
			array('slug', 'uniqueSlug', 'on' => 'update'),
			array('lang_id', 'uniqueRoot', 'on' => 'root'),
		);
	}

	public function uniqueRoot() {
		if(!$this -> hasErrors()) {
			if($this -> roots() -> countByAttributes(array('lang_id' => $this -> lang_id))) {
				$this -> addError("lang_id", Yii::t("category", "Root with language ID {ID} already exists", array(
					'{ID}' => sprintf("<strong>%s</strong>", $this -> lang_id),
				)));
			}
		}
	}

	public function uniqueSlug() {
		if(!$this -> hasErrors()) {
			$children = $this -> parentNode -> children() -> findAll();
			foreach($children as $child) {
				if(!$this -> isNewRecord && $child -> id == $this -> id) {
					continue;
				}
				if($child -> slug == $this -> slug) {
					$this -> addError("slug", Yii::t("category", "Category with slug {Slug} already exists in {CategoryName}", array(
						"{Slug}" => sprintf("<strong>%s</strong>", $this -> slug),
						"{CategoryName}" => sprintf("<strong>%s</strong>", $this -> parentNode -> title),
					)));
				}
			}
		}
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t("category", "Category ID"),
			'title' => Yii::t("category", "Title"),
			'lang_id' => Yii::t("category", "Language ID"),
			'slug' => Yii::t("category", "Slug"),
		);
	}

	/**
	* This event is raised before the record is inserted or updated.
	*
	* @param void
	* @return void
	*/
	public function beforeSave() {
		if(parent::beforeSave()) {
			$now = date("Y-m-d H:i:s");
			if($this->isNewRecord) {
				$this -> created_at = $now;
				$this -> modified_at = $now;
			} else {
				$this -> modified_at = $now;
			}
			return true;
		} else {
			return false;
		}
	}

	public function findByPath($path) {
		$cats = explode('/', trim($path, "/"));
		$cat = Helper::getLastElement($cats);
		$level = count($cats) + 1;
		$attributes = array(
			'slug' => $cat,
			'level' => $level,
			'lang_id' => Yii::app() -> language,
		);
		$categories = $this -> cache(Yii::app()->params["params.cat_cache_time"]) -> findAllByAttributes($attributes);

		if(empty($categories)) {
			return null;
		}

		//var_dump(count($categories));

		if(count($categories) == 1) {
			return $categories[0];
		}

		if(count($categories) > 1) {
			$criteria = new CDbCriteria;
			$criteria -> order = 't.root, t.lft';

			foreach($categories as $category) {
				$p_cats = array_slice($cats, 0, count($cats) - 1);
				//dump($p_cats);
				$j = 0;
				$parents = $category -> cache(Yii::app()->params["params.cat_cache_time"]) -> parent() -> findAll($criteria);
				$parents = array_slice($parents, 1, count($parents));
				foreach($parents as $parent) {
					if($p_cats[$j] == $parent -> slug) {
						unset($p_cats[$j]);
					}
					$j++;
					//dump($parent -> slug);
				}
				if(empty($p_cats)) {
					return $category;
				}
				//dump('title: '. $category -> title);
				//dump(empty($p_cats));
				//echo '==========<br>';
			}
		}
		return null;
	}

	public function formatRootPath($root = false, $separator = '/') {
		$path = '';
		$parents = $this -> getParents();
		$position = $root ? 0 : 1;
		$parents = array_slice($parents, $position, count($parents));

		foreach($parents as $parent) {
			$path .= CHtml::encode($parent -> title) . ' '. $separator. ' ';
		}
		return trim($path . (empty($path) ? ' ': ''). CHtml::encode($this -> title));
	}

	public function getParentsLink() {
		$links = array();
		$parents = $this -> getParents();

		array_shift($parents);
		$path = '';
		$c = Yii::app() -> controller;
		$i = 0;
		foreach($parents as $parent) {
			$path .= $parent -> slug . '/';
			$links[$i]['anchor'] = CHtml::encode($parent -> title);
			$links[$i]['link'] = $c -> createUrl("category/index", array("path" => trim($path, "/")));
			$links[$i]['last'] = false;
			$i++;
		}
		$links[$i]['anchor'] = CHtml::encode($this -> title);
		$links[$i]['link'] = $c -> createUrl("category/index", array("path" => $path . $this -> slug));
		$links[$i]['last'] = true;
		return $links;
	}

	public function getParents() {
		if(empty($this -> parents)) {
			$criteria = new CDbCriteria;
			$criteria -> select = 't.title, t.slug';
			$criteria -> order = 't.root, t.lft';
			$this -> parents = $this -> cache(Yii::app()->params["params.cat_cache_time"]) -> parent() -> findAll($criteria);
		}
		return $this -> parents;
	}

	public function getRoots() {
		$root = $this -> cache(Yii::app()->params["params.cat_cache_time"]) -> findByAttributes(array(
			'level' => 1,
			'lang_id' => Yii::app() -> language,
		));
		if($root == null) {
			return array();
		}
		$roots = $root -> cache(Yii::app()->params["params.cat_cache_time"]) -> children() -> findAllByAttributes(array(
			'lang_id' => Yii::app() -> language,
		));
		return $roots == null ? array() : $roots;
	}

}