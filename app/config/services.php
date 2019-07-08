<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use App\library\Auth\Auth;
use App\library\Acl\Acl;

//use lib\Funcions;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);


            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);
            //add function start
            $compiler = $volt->getCompiler();
//            $compiler->addExtension(new Zphalcon\Tools\VoltFunctions());
            $compiler->addFunction(
                'calTimeDiff',
                function ($resolvedArgs, $exprArgs) use ($compiler) {
                    // Resolve the first argument
                    $firstArgument = $compiler->expression($exprArgs[0]['expr']);

                    // Checks if the second argument was passed
                    if (isset($exprArgs[1])) {
                        $secondArgument = $compiler->expression($exprArgs[1]['expr']);
                    } else {
                        // Use '10' as default
                        $secondArgument = '10';
                    }
                    return 'lib\Funcions::calculateTimeDiff(' . $firstArgument . ', ' . $secondArgument . ')';
                }
            );
            $compiler->addFunction(
                'getResult',
                function () {

                    return 'lib\Funcions::getResult()';
                }
            );
            $compiler->addFunction(
                'resultIsNotEmpty',
                function () {

                    return 'lib\Funcions::resultIsNotEmpty()';
                }
            );
            $compiler->addFunction(
                'getLessTime',
                function ($resolvedArgs, $exprArgs) use ($compiler) {
                    // Resolve the first argument
                    $firstArgument = $compiler->expression($exprArgs[0]['expr']);
                    return 'lib\Funcions::getLessTime(' . $firstArgument . ')';
                }
            );
            $compiler->addFunction(
                'isLate',
                function ($resolvedArgs, $exprArgs) use ($compiler) {
                    // Resolve the first argument
                    $firstArgument = $compiler->expression($exprArgs[0]['expr']);
                    return 'lib\Funcions::isLate(' . $firstArgument . ')';
                }
            );
            $compiler->addFunction(
                'endTimeIsNullInit',
                function ($resolvedArgs, $exprArgs) use ($compiler) {
                    // Resolve the first argument
                    $firstArgument = $compiler->expression($exprArgs[0]['expr']);
                    $secondArgument = $compiler->expression($exprArgs[1]['expr']);
                    return 'lib\Funcions::endTimeIsNullInit(' . $firstArgument . ',' . $secondArgument . ')';
                }
            );
            $compiler->addFunction(
                'endTimeIsnull',
                function () {
                    return 'lib\Funcions::endTimeIsnull()';
                }
            );
            $compiler->addFunction(
                'getHourEndId',
                function () {
                    return 'lib\Funcions::getHourEndId()';
                }
            );
            $compiler->addFunction(
                'getTotalHoursForToday',
                function ($resolvedArgs, $exprArgs) use ($compiler) {
                    $userId = $compiler->expression($exprArgs[0]['expr']);
                    $year = $compiler->expression($exprArgs[1]['expr']);
                    $month = $compiler->expression($exprArgs[2]['expr']);
                    $day = $compiler->expression($exprArgs[3]['expr']);
//                    print_die($userId);
                    return 'lib\Funcions::getTotalHoursForToday(' . $userId . ',' . $year . ',' . $month . ',' . $day . ')';
                }
            );
            //add function end

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});
//add function


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'charset' => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
$di->set('auth', function () {
    return new Auth();
});
$di->setShared('AclResources', function () {
    $pr = [];
    if (is_readable(APP_PATH . '/config/privateResources.php')) {
        $pr = include APP_PATH . '/config/privateResources.php';
    }
    return $pr;
});

/**
 * Access Control List
 * Reads privateResource as an array from the config object.
 */
$di->set('acl', function () {
    $acl = new Acl();
    $pr = $this->getShared('AclResources')->privateResources->toArray();
    $acl->addPrivateResources($pr);
    return $acl;
});
