<?php

require LIBS_DIR . '/Nette/loader.php';

Debug::enable();
Debug::$strictMode = TRUE;
Debug::$showLocation = TRUE;

Environment::loadConfig();

$application = Environment::getApplication();
$application->errorPresenter = 'Error';
//$application->catchExceptions = TRUE;

//Session start
$session = Environment::getSession();
$session->setExpiration('+ 14 days');

//Database connection
$application->onStartup[] = 'BaseModel::initialize';
$application->onShutdown[] = 'BaseModel::disconnect';

$router = $application->getRouter();

// mod_rewrite detection
if (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules())) {
	$router[] = new Route('index.php', array(
		'presenter'	=> 'Default',
	), Route::ONE_WAY);

	$router[] = new Route('<presenter>/<action>', array(
		'presenter' => 'Default',
		'action'		=> 'default',
	));

} else {
	$router[] = new SimpleRouter('Default:default');
}

$application->run();
