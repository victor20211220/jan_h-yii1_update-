<?php
class UrlManager extends CUrlManager {
	public function createUrl($route, $params=array(), $ampersand='&') {
		if(!isset($params['language'])) {
			$params['language'] = Yii::app() -> language;
		}
		return $this -> fixPathSlashes(parent::createUrl($route, $params, $ampersand));
	}

	protected  function fixPathSlashes($url) {
		return preg_replace('#\%2F#i', '/', $url);
	}
}