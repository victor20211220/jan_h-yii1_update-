<?php
class UserController extends BackController {
    public function init() {
        parent::init();
        $cs = Yii::app()->clientScript;
        $script = "
            translation.delete_user = '".addslashes(Yii::t("user", "Are you sure want to remove this user?"))."';
            translation.block_user = '".addslashes(Yii::t("user", "Are you sure want to block this user?"))."';;
            translation.unblock_user = '".addslashes(Yii::t("user", "Are you sure want to unblock this user?"))."';;
        ";
        $cs -> registerScript(1, $script, CClientScript::POS_HEAD);
    }

	public function actionIndex() {
		$user = new User("search");
        $user -> unsetAttributes();
        if(isset($_GET['User']))
            $user -> attributes = $_GET['User'];

        $this->title=Yii::t("user", "Users");
		$this -> render("//user/index", array(
			'user' => $user,
		));
	}

	public function actionCreate() {
		$form = new CreateUserForm;
		$this -> title = Yii::t("user", "Create User");

		if(Yii::app() -> request -> isPostRequest && !empty($_POST['CreateUserForm'])) {
			$form -> attributes = $_POST['CreateUserForm'];
			if($form -> validate()) {
				$user_data = $form -> getAttributes();
				unset($user_data['password2'], $user_data['full_name'], $user_data['email']);
				$profile_data = $form -> getAttributes();
				unset($profile_data['login'], $profile_data['password']);

				$scenario = "create";
				$user = new User($scenario);
				$profile = new Profile($scenario);

				$transaction = Yii::app() -> db -> beginTransaction();
				try {
					$user -> attributes = $user_data;
					$profile -> attributes = $profile_data;
					$user -> save(false);
					$profile -> owner_id = $user -> id;
					$profile -> save(false);

					$transaction -> commit();
					Yii::app() -> user -> setFlash('success', Yii::t("user", "User has been created"));
					$this -> redirect(array("admin/user/view/", "id" => $user -> id));
				} catch (Exception $e) {
					$transaction -> rollback();
					Yii::app() -> user -> setFlash('danger', Yii::t("error", "An error occurred while inserting into database"));
					$this -> refresh();
				}
			}
		}

		$this -> render("//user/create", array(
			'form' => $form,
		));
	}

	public function actionView($id) {
        $user = $this -> loadModel($id);
		$this -> title = Yii::t("user", "{Username}: Details", array("{Username}" => CHtml::encode($user->profile->full_name)));

		$this -> render("//user/view", array(
			'user' => $user,
		));
	}

	public function actionChangeStatus($id, $status) {
        $user = $this -> loadModel($id);
        $user -> status = $status == 'block' ? User::STATUS_BLOCK : User::STATUS_ACTIVE;
        if($user -> save()) {
            Yii::app()->user->setFlash("success", Yii::t("user", "User status has been changed"));
        } else {
            Yii::app()->user->setFlash("danger", Yii::t("error", "An error occurred while updating record"));
        }
        $this ->redirect(Yii::app() -> request -> urlReferrer);
	}

	public function actionUpdate($id) {
        $user = $this -> loadModel($id);
        $this -> title = Yii::t("user", "{Username}: Update info", array(
            '{Username}' => CHtml::encode($user -> profile -> full_name),
        ));
        $form = new UserUpdateForm();
        if(Yii::app() -> request -> isPostRequest && !empty($_POST['UserUpdateForm'])) {
            $form -> attributes = $_POST['UserUpdateForm'];
            $form -> owner_id = $user -> id;
            if($form -> validate()) {
                $transaction = Yii::app() -> db -> beginTransaction();
                try {
                    $user -> login = $form -> login;
                    $user -> save();
                    Profile::model() -> updateByPk($user -> id, array(
                       'email' => $form -> email,
                       'full_name' => $form -> full_name,
                    ));
                    $transaction -> commit();
                    Yii::app()->user->setFlash("success", Yii::t("user", "User information has been updated"));
                    $this -> redirect(array("admin/user/view/", "id" => $user -> id));
                } catch(Exception $e) {
                    $transaction -> rollback();
                    Yii::app() -> user -> setFlash('danger', Yii::t("error", "An error occurred while updating record"));
                    $this -> refresh();
                }
            }
        }
        $this -> render("//user/update", array(
            'form' => $form,
            'user' => $user,
        ));
	}

	public function actionDelete($id) {
        $user=$this->loadModel($id);
        $transaction=Yii::app()->db->beginTransaction();
        try {
            $user -> delete();
            $transaction -> commit();
            Yii::app()->user->setFlash("success", Yii::t("user", "User has been deleted"));
        } catch(Exception $e) {
            Yii::app()->user->setFlash("danger", Yii::t("error", "An error occurred while removing record"));
        }
        $this -> redirect(array("admin/user/index"));
	}

	public function actionResetPassword($id) {
        $user=$this->loadModel($id);
        $this -> title = Yii::t("user", "{Username}: Reset password", array(
           "{Username}" => CHtml::encode($user->profile->full_name),
        ));
        $form = new ResetPasswordForm;
        if(Yii::app() -> request -> isPostRequest && !empty($_POST['ResetPasswordForm'])) {
            $form -> attributes = $_POST['ResetPasswordForm'];
            if($form -> validate()) {
                $user -> salt = $user->generateSalt();
                $user -> password = $user->hashPassword($form->password, $user->salt);
                if($user -> save()) {
                    Yii::app()->user->setFlash("success", Yii::t("user", "Password has been changed"));
                } else {
                    Yii::app()->user->setFlash("danger", Yii::t("error", "An error occurred while updating record"));
                }
                $this -> redirect(array("admin/user/view", "id" => $user->id));
            }
        }
        $this -> render("//user/reset_password", array(
            "user"=>$user,
            "form"=>$form,
        ));
	}

    protected function loadModel($id) {
        if($model = User::model() -> findByPk($id) /*AND !$model->isSuperUser()*/) {
            return $model;
        }
        throw new CHttpException(404, Yii::t("error", "The page you are looking for doesn't exists"));
    }

    public function actionPermissions($id) {
        $user = $this->loadModel($id);
        $this->title=Yii::t("user", "{Username}: Change permissions", array(
           '{Username}'=>CHtml::encode($user->profile->full_name),
        ));
        $groups = array(
            'Category module'=>'admin.category.*',
            'Tools module'=>'admin.tools.*',
            'Website module'=>'admin.url.*',
        );
        $auth = Yii::app()->getAuthManager();
        $userItems=$auth->getAuthItems(CAuthItem::TYPE_OPERATION, $id);
        $allItems=$auth->getAuthItems(CAuthItem::TYPE_OPERATION);
        $groupItems=$this->chunkByKeyRegEx($allItems, $groups);


        if(Yii::app()->request->isPostRequest) {
            $transaction = Yii::app() -> db -> beginTransaction();
            try {
                $auth->revokeAll($id);
                foreach($_POST as $itemname=>$value) {
                    if(isset($allItems[$itemname])) {
                        $auth->assign($itemname, $id);
                    }
                }
                $auth->save();
                $transaction->commit();
                Yii::app()->user->setFlash("success", Yii::t("user", "Permissions has been updated"));
            } catch(Exception $e) {
                $transaction -> rollback();
                Yii::app() -> user -> setFlash('danger', Yii::t("error", "An error occurred while updating record"));
            }
            $this -> refresh();
        }

        $this->render("//user/permissions", array(
            "user"=>$user,
            "userItems"=>$userItems,
            "groupItems"=>$groupItems,
        ));
    }

    protected function chunkByKeyRegEx($items, $groups) {
        $chunk=array();
        foreach($items as $key=>$item) {
            foreach($groups as $group=>$pattern) {
                if(preg_match("#$pattern#", $key)) {
                    $chunk[$group][$key]=$item;
                }
            }
        }
        return $chunk;
    }

	/*public function actionInstall() {
        $auth = Yii::app() -> authManager;

        $auth->createOperation('admin_category_roots', 'admin_category_roots');
        $auth->createOperation('admin_category_createroot', 'admin_category_createroot');
        $auth->createOperation('admin_category_update', 'admin_category_update');
        $auth->createOperation('admin_category_create', 'admin_category_create');
        $auth->createOperation('admin_category_remove', 'admin_category_remove');
        $auth->createOperation('admin_category_move', 'admin_category_move');
        $auth->createOperation('admin_category_manage', 'admin_category_manage');
        $auth->createOperation('admin_category_node', 'admin_category_node');
        $auth->createOperation('admin_category_dropdowncategory', 'admin_category_dropdowncategory');
        $auth->createOperation('admin_category_suggest', 'admin_category_suggest');
        $auth->createOperation('admin_category_deletesuggest', 'admin_category_deletesuggest');

        $auth->createOperation('admin_tools_index', 'admin_tools_index');
        $auth->createOperation('admin_tools_generatesitemap', 'admin_tools_generatesitemap');
        $auth->createOperation('admin_tools_clearcache', 'admin_tools_clearcache');

        $auth->createOperation('admin_url_index', 'admin_url_index');
        $auth->createOperation('admin_url_view', 'admin_url_view');
        $auth->createOperation('admin_url_update', 'admin_url_update');
        $auth->createOperation('admin_url_delete', 'admin_url_delete');
        $auth->createOperation('admin_url_brokenlinks', 'admin_url_brokenlinks');
        $auth->createOperation('admin_url_deletebrokenlinks', 'admin_url_deletebrokenlinks');
        $auth->createOperation('admin_url_updatereport', 'admin_url_updatereport');
        $auth->createOperation('admin_url_viewupdate', 'admin_url_viewupdate');
        $auth->createOperation('admin_url_deletecustomupdate', 'admin_url_deletecustomupdate');

        $auth->assign('admin_url_index', 2);
        $auth->assign('admin_url_view', 2);

        $auth -> save();
	}*/

}