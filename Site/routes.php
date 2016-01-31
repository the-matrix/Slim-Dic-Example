<?php
/**
 * the-matrix-slim-dic-example
 *
 * This is the site routing file, included by run.php
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license GPL V3+ See LICENSE.md
 */
/**
 * Define routes - all pure Slim from here - use MVC controllers defined in DIC
 * as per examples below or straight function definitions.  Anything you can do
 * with Slim, you can do here.
 *
 * Oh - you are not obligated to use the Site\Controller at all. It's
 * a freeby if you wish to partake. Classic MVC pattern though, allows you to separate
 * your routing out here, and deal with view logic at the controller level.  Controllers
 * use Twig templating for the view layer by default.  It's all configurable in the
 * DI definition - have fun.
 *
 * One side effect of Slim's callable pattern : we get lazy loading by default - nice!
 */
$app->get('/',
    function ($request, $response) {
        return $this->get('controller.index')->route('index', $request, $response);
    }
)
    ->setName('home');

/**
 * Security controller has an authentication model injected in the DIC
 * You might also want to play with route grouping to group around a controller
 */
$app->get('/logon',
    function ($request, $response) {
        return $this->get('controller.security')->route('logon', $request, $response);
    }
)
    ->setName('logon'); //only setting route name once

$app->post('/logon',
    function ($request, $response) {
        return $this->get('controller.security')->route('logon', $request, $response, $request->getParsedBody());
    }
);

