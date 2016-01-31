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

use Site\Model\Authenticator;
use chippyash\Type\String\StringType;
use Interop\Container\ContainerInterface;
use Site\Controller\Traits\AfterActionLoggable;

/**
 * Security controller
 */
class SecurityController extends AbstractController
{
    use AfterActionLoggable;

    /**
     * @var Authenticator
     */
    protected $authenticator;

    /**
     * Constructor
     *
     * @param ContainerInterface $dic
     * @param array $config     Optional additional configuration
     *
     * @throws \Exception
     */
    public function __construct(ContainerInterface $dic, array $config = [])
    {
        if (!array_key_exists('authenticator', $config)) {
            throw new \Exception('SecurityController expects an Authenticator');
        }
        
        $this->setAuthenticator($config['authenticator']);
        unset($config['authenticator']);
        parent::__construct($dic, $config);
    }
    
    /**
     * Attempt a logon
     * 
     * @param array $params Arbitrary parameters for the action
     *
     * @return ResponseInterface
     */
    public function logonAction(array $params = [])
    {
        if ($this->request->isPost()) {
            if ($this->authenticator->authenticate(
                new StringType($params['uid']),
                new StringType($params['pwd'])
            )
            ) {
                return $this->render('logonok');
            } else {
                return $this->render('logonfail');
            }
        }
        //NB in the case of a GET, we are automatically going to render the
        //security/logon.twig view as we haven't returned a response, so we don't
        // need to handle it explicitly.
        //The routing only allows GET and POST
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
