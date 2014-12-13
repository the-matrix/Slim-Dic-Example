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
use Slim\Slim;
use Site\Model\Authenticator;
use chippyash\Type\String\StringType;

/**
 * Security controller
 */
class SecurityController extends AbstractController
{
    /**
     * @var Site\Model\Authenticator
     */
    protected $authenticator;
    
    /**
     * Constructor
     * @extend
     * 
     * @param Slim $app
     * @param array $config Configuration for the controller
     */
    public function __construct(Slim $app, array $config = [])
    {
        if (!array_key_exists('authenticator', $config)) {
            throw new \Exception('SecurityController expects an Authenticator');
        }
        
        $this->setAuthenticator($config['authenticator']);
        unset($config['authenticator']);
        parent::__construct($app, $config);
    }
    
    /**
     * Attempt a logon
     * 
     * @param array $params Arbitrary parameters for the action
     */
    public function logonAction(array $params = [])
    {
        if ($this->request->getMethod() === 'POST') {
            if ($this->authenticator->authenticate(
                    new StringType($this->request->post('uid')),
                    new StringType($this->request->post('pwd'))))
            {
                $this->render('logonok.twig');
            } else {
                $this->render('logonfail.twig');
            }
        } elseif ($this->request->getMethod() == 'GET') {
            $this->render('logon.twig');
        }
    }
    
    /**
     * Yes I know - it would be better to use an interface - but it's a demo!
     * This method's main purpose is to type check the authenticator
     * merely by its parameter declaration
     * 
     * @param Authenticator $authenticator
     */
    protected function setAuthenticator(Authenticator $authenticator) {
        $this->authenticator = $authenticator;
    }
}
