<?php
class ThemeManager extends CThemeManager {
	protected $hasBeenInitialized = false;
	public $themes = array();
	
	public function hasBeenInitialized() {
		return $this -> hasBeenInitialized;
	}

	public function initialized() {
		$this -> hasBeenInitialized = true;
	}
	
	public function getThemeDir($end) {
		return isset($this -> themes[$end]) ? $this -> themes[$end] : 'classic';
	}

}