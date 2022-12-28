<?php
class FlexibleCaptchaBlank implements IFlexibleCaptcha
{
    public function getModelLabelText()
    {
        return '';
    }

    public function render(array $params = array(), $view = null)
    {
        return '';
    }

    public function appendValidationRule(array &$rules, array $additional = array())
    {
    }

    public function appendAction(array &$actions, $key)
    {
    }

    public function isAllowed()
    {
        return false;
    }
}