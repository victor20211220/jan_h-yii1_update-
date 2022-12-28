<?php

class PremiumcheckerCommand extends CConsoleCommand {
    public function actionIndex() {
        $command = Yii::app() -> db -> createCommand();
        $premium_links=$command
            ->select("id, url, title")
            ->from("{{website}}")
            ->where("type=:type", array(":type"=>Website::TYPE_PREMIUM))
            ->queryAll();

        $finder = new LinkFinder();
        $finder->setHref(Helper::getBackUrl());
        foreach($premium_links as $premium) {
            $finder->setUrl($premium['url']);
            if($finder->exists()) {
                PremiumCheck::model()->deleteByPk($premium['id']);
            } else {
                $model = PremiumCheck::model()->findByPk($premium['id']);
                if($model==null) {
                    $model = new PremiumCheck();
                    $model->website_id=$premium['id'];
                    $model->attempts=1;
                } else {
                    $model->attempts=$model->attempts + 1;
                }
                if($model->attempts-1 < Yii::app()->params["params.premium_backlink_attempts"]) {
                    $model->save();
                } else {
                    Website::model()->updateByPk($premium['id'], array(
                       'type'=>Website::TYPE_REGULAR,
                    ));
                    $model->deleteByPk($premium['id']);
                    $log = new SystemLog();
                    $log -> module = "CRON module";
                    $log -> log = "URL: {Link}. Status has been changed from Premium to Regular";
                    $log -> params = array('{Link}'=>CHtml::link($premium['title'], Yii::app()->createAbsoluteUrl("admin/url/view", array("id" => $premium['id'])), array("target"=>"_blank")));
                    $log -> save();
                }
            }
        }
    }
}