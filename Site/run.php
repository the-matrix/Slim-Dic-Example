<?php
/**
 * the-matrix-slim-dic-example
 *
 * This is the 'real' run file. Called by public/index.php
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license GPL V3+ See LICENSE.md
 */
require dirname(__DIR__) . '/vendor/autoload.php';

use Site\Model\Environment;
use Slimdic\Dic\Builder;
use Slimdic\Dic\ServiceContainer;
use Chippyash\Type\String\StringType;
use Slim\App;

//you might consider moving this to an if/case block dependent on Environment
error_reporting(E_ALL);
Environment::setEnvironmentState(Environment::ENVSTATE_DEV);
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
//system base directory
$baseDir = dirname(__DIR__);
//Name of dic file to load dependent on environment and PHP version
$diFileName = new StringType(
    $baseDir . '/Site/cfg/' . (PHP_MAJOR_VERSION < 7 ? 'php5' : 'php71') . '/dic.' . Environment::getEnvironmentState() . '.xml'
);

/**
 * build dic and setup Slim app
 * Once installed, there is nothing to stop you extending or overiding the
 * builder to massage your system just the way you want it
 *
 * Please also note that there is no caching of the DIC going on here.  As there is
 * no well defined caching interface, it's up to you to implement.  I like the
 * zendframework/zend-cache component, but you can choose.  Essentially:
 *
 * if ($cache->hasItem('dic')) {
 *    $dic = $cache->getItem('dic');
 * } else {
 *    Builder::registerPreCompileFunction(function(ServiceContainer $dic) use($baseDir) {
 *      $dic->setParameter('baseDir', $baseDir);
 *    });
 *
 *    $dic = Builder::buildDic($diFileName);
 *    $cache->saveItem('dic', $dic);
 * }
 */

Builder::registerPreCompileFunction(function($dic) use($baseDir) {
    $dic->setParameter('baseDir', $baseDir);
});

//following are globally available in the routes.php script
$dic = Builder::buildDic($diFileName);
$app = new App($dic);

//clean up
unset($baseDir, $diFileName);

//do routing
include 'routes.php';

// Run app
$app->run();
