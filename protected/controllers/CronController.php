<?php
class CronController extends FrontController {
	public function init() {
        parent::init();
		$app_key = (string) Yii::app() -> params['app.command_key'];
		$get_key = (string) Yii::app() -> request -> getQuery('key');
		if(empty($app_key)) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}
		if(strcmp($app_key, $get_key) !== 0) {
			throw new CHttpException(400, Yii::t("error", "Bad request"));
		}
	}

	public function actionSitemap() {
		// params
		$args = array('yiic', 'sitemap', 'index');

		// Get command path
		$commandPath = Yii::app() -> getBasePath() . DIRECTORY_SEPARATOR . 'commands';

		// Create new console command runner
		$runner = new CConsoleCommandRunner();

		// Adding commands
		$runner -> addCommands($commandPath);

		// If something goes wrong return error
		$runner -> run ($args);

		echo 'ok';
	}

	public function actionPremiumchecker() {
		// params
		$args = array('yiic', 'premiumchecker', 'index');

		// Get command path
		$commandPath = Yii::app() -> getBasePath() . DIRECTORY_SEPARATOR . 'commands';

		// Create new console command runner
		$runner = new CConsoleCommandRunner();

		// Adding commands
		$runner -> addCommands($commandPath);

		// If something goes wrong return error
		$runner -> run ($args);

        echo 'ok';
	}

    public function actionUrlCalculator() {
        // params
        $args = array('yiic', 'urlcalculator', 'index');

        // Get command path
        $commandPath = Yii::app() -> getBasePath() . DIRECTORY_SEPARATOR . 'commands';

        // Create new console command runner
        $runner = new CConsoleCommandRunner();

        // Adding commands
        $runner -> addCommands($commandPath);

        // If something goes wrong return error
        $runner -> run ($args);

        echo 'ok';
    }
}