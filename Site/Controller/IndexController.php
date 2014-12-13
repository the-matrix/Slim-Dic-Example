<?php
/*
 * The-Matrix Demonstration App for Slimdic 
 * 
 * Site Controllers
 * 
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2014, UK
 */
namespace Site\Controller;

use Slimdic\Controller\AbstractController;

/**
 * Main site index controller
 */
class IndexController extends AbstractController
{
    public function indexAction(array $params = [])
    {
        $this->app->log->info("app-config '/' route");
        $this->render('index.twig');
    }
}
