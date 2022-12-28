<?php
Yii::import("ext.ecountrylist.ECountryList");

class UrlController extends BackController {

	public function actionIndex() {

        $this -> title = Yii::t("website", "Manage URLs");
		$getScope = Yii::app() -> request -> getQuery('type');
		$defaultScope = 'all';
		$model = Website::model();

        $model -> unsetAttributes();
        $model -> scenario = 'search';
        if(isset($_GET['Website']))
            $model -> attributes = $_GET['Website'];

		$scopes = $model -> scopes();
		$scope = in_array($getScope, array_merge(array('category'), array_keys($scopes))) ? $getScope : $defaultScope;

		$this -> render("//url/index", array(
			'scope' => $scope,
			'model' => $model,
			'params' => array(
                'category_id' => Yii::app() -> request -> getQuery('category_id'),
            ),
		));
	}

	public function actionView($id = null) {
		if(!$website = Website::model() -> with(array(
            'category' => array('select' => 'title, id, lft, rgt, level, root'),
            'statistic' => array('select' => 'hits'),
            'user',
        )) -> findByPk($id)) {
			throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
		}
        $this -> title = Yii::t("website", "Link information");
		$this -> render("//url/view", array(
			'website' => $website,
		));
	}

	public function actionUpdate($id = null) {
		if(!$website = Website::model() -> findByPk($id)) {
			throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
		}

        $this -> title = Yii::t("website", "Update Info");

		$emailForm = new EmailForm();

		if(Yii::app() -> request -> isPostRequest AND isset($_POST['Website'])) {

			$statusHasBeenChanged = (isset($_POST['Website']['status']) AND $_POST['Website']['status'] != $website -> status);
			$send_email = (bool) Yii::app() -> request -> getPost('send_email');

			$website -> attributes = $_POST['Website'];
            $website -> md5url = Helper::md5Url($_POST['Website']['url']);
			$emailForm -> attributes = $_POST['EmailForm'];

            $validWebsite = $website -> validate();
            $validEmail = $emailForm -> validate();

			if($statusHasBeenChanged AND $send_email AND $validEmail AND $validWebsite) {
				try {
                    $mailer = new YiiMailer();
                    $mailer->clearAddresses();
                    $mailer->clearReplyTos();
                    $mailer->setSubject($emailForm -> subject);
                    $mailer->setFrom(Yii::app() -> params['notification.email'], Yii::app() -> params['notification.name']);
                    $mailer->addAddress($emailForm -> to);
                    $mailer->setBody(nl2br($emailForm -> body));
                    $mailer->setAltText($emailForm -> body);
                    $mailer->send();

					Yii::app() -> user -> appendFlash('success', Yii::t("email", "Email has been sent"));
				} catch (phpmailerException $e) {
					Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
					Yii::app() -> user -> setFlash('warning', Yii::t("email", "An error occurred while sending email"));
				}
			}

            if($website->getError('md5url')) {
                $website->addError('url', $website->getError('md5url'));
                $website->clearErrors('md5url');
            }

            if($validWebsite AND (!$statusHasBeenChanged OR $validEmail)) {
				if($website -> save(false)) {
					$log = new SystemLog();
					$log -> module = "Website module";
					$log -> log = "{User} has updated webiste's ({Website}) information";
					$log -> params = array('{Website}' => $website -> getViewUrl());
					$log -> save();

					Yii::app() -> user -> appendFlash('success', Yii::t("website", "Information has been updated"));
				} else {
					Yii::app() -> user -> appendFlash('danger', Yii::t("error", "An error occurred while inserting into database"));
				}
				$this -> refresh();
			}
		}

		$e_template = array();
		$country_list = ECountryList::getInstance(Yii::app() -> language) -> getSortedCountries();

		$temp_lg = Yii::app() -> language;
		foreach(Yii::app() -> params["app.languages"] as $lang_id => $lang) {
			Yii::app() -> language = $lang_id;
			$params = array(
				'{BrandName}' => Yii::app() -> name,
				'{Username}' => Helper::mb_ucfirst($website -> user -> name),
				'{Title}' => $website -> title,
				'{HomeUrl}' => Helper::getInstalledUrl(),
				'{Year}' => date("Y"),
				'{Banner or TextLink}'=>CHtml::link(
						Yii::t("email", "Banner or TextLink"),
						$this->createAbsoluteUrl("site/banners"),
						array("target"=>"_blank")
				),
				'{ContactForm}'=>CHtml::link(
						Yii::t("email", "Contact Form"),
						$this->createAbsoluteUrl("site/contact"),
						array("target"=>"_blank")
				),
				'{Url}'=>$website->url,
				'{CategoryPath}'=>$website -> category -> formatRootPath(true),
				'{Link}'=>$this->createAbsoluteUrl("url/index", array('slug' => Helper::slug($website -> title), 'id' => $website -> id)),
			);
			foreach($website -> getStatusList() as $status_id => $value) {
				foreach($website -> getTypeList() as $type_id => $type) {
					$e_template[$lang_id][$status_id][$type_id]['subject'] =
						$website -> getEmailString('Subject', $params, true, $status_id, $type_id);
					$e_template[$lang_id][$status_id][$type_id]['body'] =
						$website -> getEmailString('Body', $params, true, $status_id, $type_id);
				}
			}
		}
		Yii::app() -> language = $temp_lg;

		$this -> render("//url/update", array(
			'website' => $website,
			'country_list' => $country_list,
			'e_template' => $e_template,
			'emailForm' => $emailForm,
		));
	}

    public function actionExistDofollowLink($id) {
        if(!$website = Website::model() -> findByPk($id)) {
            throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
        }
        $finder=new LinkFinder();
        $finder->setUrl($website->url);
        $finder->setHref(Helper::getBackUrl());
        if($finder->exists()) {
            Yii::app()->user->setFlash("success", Yii::t("website", "Excellent! Script has found dofollow link"));
        } else {
            Yii::app()->user->setFlash("warning", Yii::t("website", "Attention! Script didn't find dofollow link"));
        }
        $this->redirect(array("admin/url/update", "id"=>$id));
    }

    public function actionDelete($id) {
        if(!$website = Website::model() -> findByPk($id)) {
            throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
        }

        $transaction = Yii::app() -> db -> beginTransaction();
        try {
            $log = new SystemLog();
            $log -> module = "Website module";
            $log -> log = "{Link} has been deleted by {User}";
            $log -> params = array('{Link}' => $website -> url);
            $log -> save();
            Website::model() -> deleteByPk($id);
            UserUpload::model() -> deleteByPk($id);
            Statistic::model() -> deleteByPk($id);
            $transaction -> commit();
        } catch (Exception $e) {
            $transaction -> rollback();
        }
    }

    public function actionBrokenLinks() {
        $this -> title = Yii::t("website", "Broken links");

        $dataProvider =  new CActiveDataProvider(new BrokenLink, array(
            'criteria' => array(
                'with' => array(
                    'website' => array(
                        'select' => 'url, title',
                    ),
                ),
            ),
            'pagination' => array(
                'pageSize' => Yii::app() -> params["params.admin_broken_links"],
            ),
        ));


        $this -> render("//url/brokenlinks", array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionDeleteBrokenLinks() {
        $type = Yii::app()->request->getQuery('type');
        $method = "brokenLinks$type";
        if(method_exists($this, $method)) {
            $this -> $method();
        }
    }

    protected function brokenLinksDelete() {
        if(!isset($_POST['ids']) OR !is_array($_POST['ids'])) {
            $this ->redirect(Yii::app() -> request -> urlReferrer);
        }

        $criteria = new CDbCriteria;
        $criteria -> addInCondition('website_id', $_POST['ids']);

        $transaction = Yii::app() -> db -> beginTransaction();
        try {
            $log = new SystemLog();
            $log -> module = "Website module";
            $log -> log = "{User} has removed \"broken link report\"";
            $log -> save();
            BrokenLink::model()->deleteAll($criteria);
            $transaction -> commit();
            Yii::app() -> user -> setFlash("success", Yii::t("system_log", "Selected reports has been removed"));
        } catch (Exception $e) {
            $transaction -> rollback();
            Yii::app() -> user -> setFlash("danger", Yii::t("error", "An error occurred while removing from database"));
        }
        $this ->redirect(Yii::app() -> request -> urlReferrer);
    }

    protected function brokenLinksTruncate() {
        BrokenLink::model() -> truncateTable();
        $log = new SystemLog();
        $log -> module = "Website module";
        $log -> log = "{User} has removed \"broken link report\"";
        $log -> save();
        Yii::app() -> user -> setFlash("success", Yii::t("system_log", "All reports has been removed"));
        $this ->redirect(Yii::app() -> request -> urlReferrer);
    }

    public function actionUpdateReport() {
        $this -> title = Yii::t("website", "Update reports");

        $dataProvider =  new CActiveDataProvider(new UpdateUrl, array(
            'criteria' => array(
                'with' => array(
                    'website' => array(
                        'select' => 'url, title',
                    ),
                ),
            ),
            'pagination' => array(
                'pageSize' => Yii::app() -> params["params.admin_broken_links"],
            ),
        ));


        $this -> render("//url/updatereport", array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionViewUpdate($id) {
        if(!$update = UpdateUrl::model() -> findByPk($id)) {
            throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
        }
        $this -> title = Yii::t("website", "Request for update");
        $website = Website::model() -> findByPk($id);
        $this -> render("//url/viewupdate", array(
           "update" => $update,
           "website" => $website,
        ));
    }

    public function actionDeleteCustomUpdate() {
        $type = Yii::app()->request->getQuery('type');
        $method = "customUpdate$type";
        if(method_exists($this, $method)) {
            $this -> $method();
        }
    }

    protected function customUpdateDeleteRow() {
        $id = Yii::app() -> request ->getQuery('id');
        if(!$update = UpdateUrl::model() -> findByPk($id)) {
            throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
        }
        $transaction = Yii::app() -> db -> beginTransaction();
        try {
            $log = new SystemLog();
            $log -> module = "Website module";
            $log -> log = "{User} has removed \"request for update\"";
            $log -> save();
            $update -> delete();
            $transaction -> commit();
            Yii::app() -> user -> setFlash("success", Yii::t("system_log", "Selected reports has been removed"));
        } catch (Exception $e) {
            $transaction -> rollback();
            Yii::app() -> user -> setFlash("danger", Yii::t("error", "An error occurred while removing from database"));
        }
        $this ->redirect($this -> createUrl("admin/url/updatereport"));
    }

    protected function customUpdateDelete() {

        if(!isset($_POST['ids']) OR !is_array($_POST['ids'])) {
            $this ->redirect(Yii::app() -> request -> urlReferrer);
        }

        $criteria = new CDbCriteria;
        $criteria -> addInCondition('website_id', $_POST['ids']);

        $transaction = Yii::app() -> db -> beginTransaction();
        try {
            $log = new SystemLog();
            $log -> module = "Website module";
            $log -> log = "{User} has removed \"request for update\"";
            $log -> save();
            UpdateUrl::model()->deleteAll($criteria);
            $transaction -> commit();
            Yii::app() -> user -> setFlash("success", Yii::t("system_log", "Selected reports has been removed"));
        } catch (Exception $e) {
            $transaction -> rollback();
            Yii::app() -> user -> setFlash("danger", Yii::t("error", "An error occurred while removing from database"));
        }
        $this ->redirect(Yii::app() -> request -> urlReferrer);
    }

    protected function customUpdateTruncate() {
        $log = new SystemLog();
        $log -> module = "Website module";
        $log -> log = "{User} has removed \"request for update\"";
        $log -> save();
        UpdateUrl::model() -> truncateTable();
        Yii::app() -> user -> setFlash("success", Yii::t("system_log", "All reports has been removed"));
        $this ->redirect(Yii::app() -> request -> urlReferrer);
    }
}