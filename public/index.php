<?php
/**
 * A minimalist Slim application completely driven out of a DI container
 * supplied by Symfony.
 * 
 * Use this as a starting point for your application.
 * 
 * @copyright Ashley Kitson, 2014, UK
 */
require '../vendor/autoload.php';

use Slimdic\Environment;
use Slimdic\Dic\Builder;
use chippyash\Type\String\StringType;

//you might consider moving this to an if/case block dependent on Environment
error_reporting(E_ALL);

//set the environment mode either via Slim method or by Slimdic method
//NB - this restricts the environment to those supported by Environment.  If you 
//need to, extend the Environment class. 
if (isset($_ENV['SLIM_MODE'])) {
    //as long as SLIM_MODE validates against Environment's valid modes we are ok
    Environment::setEnvironmentState($_ENV['SLIM_MODE']);
} else {
    //If you haven't set APPLICATION_ENV, then this will default to 'production'
    $_ENV['SLIM_MODE'] = Environment::getEnvironmentState();
}

/**
 * build dic and setup Slim app
 * Once installed, there is nothing to stop you extending or overiding the 
 * builder to massage your system just the way you want it
 */
$app = Builder::getApp(
        new StringType(dirname(__DIR__)), 
        new StringType(Environment::getEnvironmentState())
        );

/**
 * Define routes - all pure Slim from here - use MVC controllers defined in DIC
 * as per examples below or straight function definitions.  Anything you can do
 * with Slim, you can do here.
 * 
 * For security, you might want to consider locating this routing in another
 * file outside of ./public 
 * 
 * To keep your code clean and non dependent on the DIC, best practice is to
 * either inject into your code at this point, any DI definitions that you need,
 * or within your DI definition XML. 
 * 
 * You can also access the DIC from within the controllers if you must!
 * 
 * Oh - you are not obligated to use the Slimdic\Controller at all. It's
 * a freeby if you wish to partake.
 * 
 * One side effect of Slim's callable pattern when using 'hard-coded' classes
 * like this: we get lazy loading by default - nice!
 */
$app->get('/', 
        function() use($app) {$app->dic->get('controller.index')->route('index');}
        );

/**
 * This controller has an authentication model injected in the DIC
 */
$app->map('/logon', 
        function() use($app) {$app->dic->get('controller.security')->route('logon');}
        )->via('GET', 'POST');
        
// Run app
$app->run();
