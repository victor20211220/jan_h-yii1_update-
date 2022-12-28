<?php
interface IFlexibleCaptcha
{
    public function getModelLabelText();
    public function render(array $params = array(), $view = null);
    public function appendValidationRule(array & $rules, array $additional = array());
    public function appendAction(array & $actions, $key);
    public function isAllowed();
}