<?php
/*
 * Chippyash Slim DIC integration
 * 
 * A slim MVC Controller factory
 * 
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 */
namespace Site\Controller;

use chippyash\Type\String\StringType;
use Interop\Container\ContainerInterface;

/**
 * Factory class to create controllers
 */
abstract class Factory
{
    /**
     * Factory method to create a controller
     * 
     * @param StringType $ctrlName Namespace name for controller
     * @param array $config Arbitrary configuration for the controller
     * 
     * @return AbstractController
     * 
     * @throws \Exception
     */
    public static function create(ContainerInterface $dic, StringType $ctrlName, array $config = [])
    {
        $cName = $ctrlName();
        if (!class_exists($cName)) {
            throw new \Exception("Class {$cName} does not exist");
        }
        $ctrl = new $cName($dic, $config);
        if (!$ctrl instanceof AbstractController) {
            throw new \Exception("{$cName} is not an instance of AbstractController");
        }
        
        return $ctrl;
    }

    /**
     * Do not allow instantiation
     */
    protected function __construct()
    {
    }
}
