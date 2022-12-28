<!DOCTYPE html>
<html lang="<?php echo Yii::app() -> language ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="php8developer.com">

<link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true) ?>/favicon.ico" />

<link href="<?php echo Yii::app()->theme->baseUrl ?>/css/flatly-bootstrap-min.css" rel="stylesheet">
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css/app.css" rel="stylesheet">

<?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/static/js/bootstrap.min.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/app.js') ?>

<script type="text/javascript">
var translation = {};
</script>
<title><?php echo CHtml::encode($this -> title) ?></title>
</head>

<body>
<?php echo $content ?>
</body>
</html>