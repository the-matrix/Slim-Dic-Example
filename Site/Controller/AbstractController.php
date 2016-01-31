<?php
/*
 * Chippyash Slim DIC integration
 * 
 * A slim MVC Controller
 * 
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 */
namespace Site\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Base abstract controller
 */
abstract class AbstractController
{
    /**
     * DI Container
     * @var ContainerInterface
     */
    protected $dic;
    
    /**
     * @var ServerRequestInterface
     */
    protected $request;
    
    /**
     * @var ResponseInterface
     */
    protected $response;
    
    /**
     * Arbitrary Controller Configuration
     * 
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $currentAction;

    /**
     * Data to be sent to the view
     * @var array
     */
    protected $viewData = [];

    /**
     * Constructor
     *
     * @param ContainerInterface $dic
     * @param array $config     Optional additional configuration for the controller
     */
    public function __construct(ContainerInterface $dic, array $config = [])
    {
        $this->dic = $dic;
        $this->config = $config;
    }
    
    /**
     * Route request to an action on this controller
     * 
     * @param string $actionName Name of action (minus 'Action' suffix)
     * @param ServerRequestInterface $req
     * @param ResponseInterface $res
     * @param array $params Arbitrary parameters to be sent to the action
     *
     * @return ResponseInterface
     *
     * @throws \Exception
     */
    public function route($actionName, ServerRequestInterface $req, ResponseInterface $res, array $params = [])
    {
        $this->request = $req;
        $this->response = $res;
        $this->currentAction = $actionName;

        $this->beforeAction($params);

        //The action (if it physically exists) can call render itself and return the response
        //we wrap this in a try/catch block as slim3 is not so helpful
        //about displaying problems
        try {
            $aName = "{$actionName}Action";
            if (method_exists($this, $aName)) {
                $rendered = $this->$aName($params);
            } else {
                $rendered = null;
            }
        } catch (\Exception $e) {
            //you should of course do something a bit more sane than this
            var_dump($e);exit;
        }

        $this->afterAction();

        //If the action did not return a response, do an automatic one
        return (is_null($rendered) ? $this->render() : $rendered);
    }

    /**
     * Do something before action is carried out
     * Override if required
     *
     * @param array $params
     */
    protected function beforeAction(array $params = [])
    {

    }

    /**
     * Do something after action is carried out
     * Override if required
     */
    protected function afterAction()
    {

    }

    /**
     * Render the template. By default will render the template associated to the
     * controller/action, e.g. index/index.twig
     *
     * @proxy view->render
     *
     * @param  string $action Action name (equates to template name)
     * @param  array  $data     Associative array of data made available to the view
     * @param  int    $status   The HTTP response status code to use (optional)
     * @param  string $controller The controller name that acts as root for the template - default = current controller
     *
     * @return ResponseInterface
     */
    protected function render($action = null, array $data = [], $status = null, $controller = null)
    {
        $ctrl = (!is_null($controller) ? $controller : $this->controllerName());
        $act = (!is_null($action) ? $action : $this->actionName());
        $tpl = "{$ctrl}/{$act}" . $this->dic->get('view.fileSuffix');
        $viewData = (empty($data) ? $this->viewData : $data);
        $sts = (is_null($status) ? 200 : $status);

        return $this->dic->get('view')
            ->render(
                $this->response->withStatus($sts),
                $tpl,
                $viewData
            );
    }

    /**
     * Name of this controller
     * @return string
     */
    protected function controllerName()
    {
        $ctrlClassParts = explode('\\', get_class($this));
        return strtolower(str_replace('Controller', '', array_pop($ctrlClassParts)));
    }

    /**
     * Name of currently executing action
     * @return string
     */
    protected function actionName()
    {
        return $this->currentAction;
    }
}
