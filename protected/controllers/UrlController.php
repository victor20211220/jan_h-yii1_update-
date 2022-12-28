<?php
Yii::import("ext.ecountrylist.ECountryList");

class UrlController extends FrontController {

	public function actionSubmit($id = 0) {
		if(!$category = Category::model() -> findByPk($id)) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}

		$submit_form = new SubmitForm();
		$submit_form -> scenario = "submit";

		$country = ECountryList::getInstance(Yii::app() -> language);
		$country_list = $country -> getSortedCountries();

		if(Yii::app() -> request -> isPostRequest && !empty($_POST['SubmitForm'])) {
			$submit_form -> attributes = $_POST['SubmitForm'];
            $submit_form -> category_id = $id;

			if($submit_form -> validate()) {

				$website = new Website();
				$user_upload = new UserUpload();
				$statistic = new Statistic();

				$website_data = $submit_form -> getAttributes();
				unset($website_data['verifyCode'], $website_data['comments'], $website_data['name'], $website_data['email']);
				$user_upload_data = $submit_form -> getAttributes();
				unset($user_upload_data['verifyCode'], $user_upload_data['domain'], $user_upload_data['title'], $user_upload_data['description'], $user_upload_data['country_id'], $user_upload_data['lang_id']);

				$website -> setAttributes($website_data);
				$website -> category_id = $id;
				$website -> lang_id = Yii::app()->language;
				
				$transaction = Yii::app() -> db -> beginTransaction();
				try {
					$params = array(
						'{BrandName}' => Yii::app() -> name,
						'{Username}' => Helper::mb_ucfirst($user_upload_data['name']),
						'{Title}' => $website['title'],
						'{HomeUrl}' => Helper::getInstalledUrl(),
						'{Year}' => date("Y"),
                        '{Url}'=>$website->url,
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
					);
					$emailBody = $website -> getEmailString('Body', $params, true, $website->status, $website->type);
					$emailSubject = $website -> getEmailString('Subject', $params, true, $website->status, $website->type);

					$website -> save(false);
					$user_upload -> attributes = $user_upload_data;
					$user_upload -> website_id = $website -> id;
					$user_upload -> save(false);
					$statistic->website_id=$website->id;
					$statistic->hits=0;
					$statistic->save(false);
					
					$transaction -> commit();
					
					Yii::app() -> user -> setFlash('success', Yii::t("website", "You URL has been submited"));

					$mailer = new YiiMailer();
                    $mailer->clearAddresses();
                    $mailer->clearReplyTos();
                    $mailer->setSubject($emailSubject);
                    $mailer->setFrom(Yii::app() -> params['notification.email'], Yii::app() -> params['notification.name']);
                    $mailer->addAddress($user_upload_data['email']);
                    $mailer->setBody(nl2br($emailBody));
                    $mailer->setAltText($emailBody);
                    $mailer->send();

				} catch (phpmailerException $e) {
					Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
					Yii::app() -> user -> setFlash('warning', Yii::t("email", "An error occurred while sending email"));
				} catch (Exception $e) {
					try { $website->delete(); } catch (Exception $e) {}
					$transaction -> rollback();
					Yii::app() -> user -> setFlash('danger', Yii::t("error", "An error occurred while inserting into database"));
				}
				$this -> refresh();
			}
		}

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{CategoryPath}' => $category -> formatRootPath(false, '&raquo;'),
		);
		$this -> title = Yii::t("meta", "submit website title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "submit website keywords", $params), 'keywords', null, array('encode' => false));
		$cs -> registerMetaTag(Yii::t("meta", "submit website description", $params), 'description', null, array('encode' => false));
        $banners = Helper::getBannerList();

		$this -> render("submit_website", array(
			'submit_form' => $submit_form,
			'country_list' => $country_list,
			'category' => $category,
            'banners'=> $banners,
		));
	}

	public function actionIndex($id = null) {
		if(!$website = Website::model() -> findByAttributes(array(
			'id' => $id,
			'lang_id' => Yii::app() -> language,
			'status' => Website::STATUS_APPROVED,
		)))  throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));

		$popular=$website->popularRelated(Yii::app()->params["params.popular_website_count"])->findAll();
        $popularThumbnailStack = WebsiteThumbnail::thumbnailStack($popular);

		$related = $website->getRelatedWebsitesInCategory();
        $relatedThumbnailStack = WebsiteThumbnail::thumbnailStack($related);

		$sm = Yii::app() -> securityManager;
		$cookie_name = "__counter";

		if(Yii::app() -> request -> cookies -> contains($cookie_name)) {
			$websites = @unserialize($sm -> decrypt(base64_decode(Yii::app() -> request -> cookies[$cookie_name] -> value)));
			if(is_array($websites) AND !in_array($website -> id, $websites)) {
				$websites[] = $website -> id;
				$this -> incrementCounter($website, $cookie_name, $websites);
			}
		} else {
			$this -> incrementCounter($website, $cookie_name, array($website -> id));
		}

		$update = UpdateUrl::model() -> countByAttributes(array("website_id" => $website -> id));
		$broken = BrokenLink::model() -> countByAttributes(array("website_id" => $website -> id));
		$category = Category::model() -> findByPk($website -> category_id);

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{UrlTitle}' => $website -> title,
			'{UrlDescription}' => Helper::cropText($website -> description, 120, ''),
		);
		$this -> title = Yii::t("meta", "website page title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "website page keywords", $params), 'keywords', null, array('encode' => false));
		$cs -> registerMetaTag(Yii::t("meta", "website page description", $params), 'description', null, array('encode' => false));

        $thumbnail=WebsiteThumbnail::getThumbData(array(
            'url'=>$website->url,
            'size'=>'l',
        ));

		$this -> render("view", array(
			'website' => $website,
			'category' => $category,
			'popular' => $popular,
			"update" => $update,
			"related" => $related,
			'relatedThumbnailStack'=>$relatedThumbnailStack,
			'popularThumbnailStack'=>$popularThumbnailStack,
			"broken" => $broken,
            "thumb"=>$thumbnail,
		));
	}

	private function incrementCounter($website, $cookie_name, array $array) {
		// Shortcut alias of securityManager
		$sm = Yii::app() -> securityManager;

		// Time in unix seconds until midnight
		$midnight = mktime(0, 0, 0, date('n'), date('j') + 1, date('Y'));

		// Encrypt and serialze data
		$websites = base64_encode($sm -> encrypt(serialize($array)));

		// Create new cookie instance
		$cookie = new CHttpCookie($cookie_name, $websites);

		// Set expire time
		$cookie -> expire = $midnight;

		// Save cookie
		Yii::app() -> request -> cookies[$cookie_name] = $cookie;

		// Increment counter
		Statistic::model() -> updateByPk($website -> id, array(
			'hits' => new CDbExpression('hits + 1'),
		));
	}

	public function actionBrokenLink($id) {
		if(!$website = Website::model() -> findByAttributes(array(
			'id' => $id,
			'lang_id' => Yii::app() -> language,
			'status' => Website::STATUS_APPROVED,
		)))  throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));


		$model = new BrokenLink;
		$reported =  BrokenLink::model() -> countByAttributes(array("website_id" => $id)) ? true : false;

		if(Yii::app() -> request -> isPostRequest && !empty($_POST['BrokenLink']) && !$reported) {
			$model -> attributes = $_POST['BrokenLink'];
			if($model -> save()) {
				Yii::app() -> user -> setFlash('success', Yii::t("website", "Thank you. Your report has been sent"));
				$this -> redirect($this -> createAbsoluteUrl("url/index", array('slug' => Helper::slug($website -> title), 'id' => $website -> id)));
			}
		}

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{UrlTitle}' => $website -> title,
			'{BrandName}' => Yii::app() -> name,
			'{Url}' => $website -> url,
			'{UrlDescription}' => Helper::cropText($website -> description, 120, ''),
		);
		$this -> title = Yii::t("meta", "broken link title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "broken link keywords", $params), 'keywords');
		$cs -> registerMetaTag(Yii::t("meta", "broken link description", $params), 'description');

		$this -> render("broken", array(
			"model" => $model,
			"website" => $website,
			"reported" => $reported,
		));
	}

	public function actionUpdate($id) {
		if(!$website = Website::model() -> findByAttributes(array(
			'id' => $id,
			'lang_id' => Yii::app() -> language,
			'status' => Website::STATUS_APPROVED,
		)))  throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));

		$url = $this -> createAbsoluteUrl("url/index", array('slug' => Helper::slug($website -> title), 'id' => $website -> id));

		if(UpdateUrl::model() -> countByAttributes(array("website_id" => $id))) {
			$this -> redirect($url);
		}

		$submit_form = new SubmitForm();
		$submit_form -> scenario = "userUpdate";

		$country = ECountryList::getInstance(Yii::app() -> language);
		$country_list = $country -> getSortedCountries();

		if(Yii::app() -> request -> isPostRequest && !empty($_POST['SubmitForm'])) {
			$submit_form->attributes = $_POST['SubmitForm'];
            $submit_form->website_id = $id;
            $submit_form->category_id = $website->category_id;

			if($submit_form -> validate()) {
				$update = new UpdateUrl();
				$update_data = $submit_form -> getAttributes();
				$update -> setAttributes($update_data);
				$update->lang_id = $website->lang_id;
				if($update -> save(false)) {
					Yii::app() -> user -> setFlash('success', Yii::t("website", "Your changes has been successfully submitted"));
					$this -> redirect($url);
				}
			}
		}

		$cs = Yii::app() -> clientScript;
		$params = array(
			'{UrlTitle}' => $website -> title,
			'{UrlDescription}' => Helper::cropText($website -> description, 120, ''),
			'{BrandName}' => Yii::app() -> name,
		);
		$this -> title = Yii::t("meta", "update website title", $params);
		$cs -> registerMetaTag(Yii::t("meta", "update website keywords", $params), 'keywords');
		$cs -> registerMetaTag(Yii::t("meta", "update website description", $params), 'description');


		$this -> render("update", array(
			"website" => $website,
			"submit_form" => $submit_form,
			"country_list" => $country_list,
			"url" => $url,
			"post" => !empty($_POST['SubmitForm']) ? $_POST['SubmitForm'] : array(),
		));
	}
}