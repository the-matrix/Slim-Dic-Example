# Using the Site/Controller

Use of the Controller pattern is optional in your application.  However, this venerable
part of the MVC paradigm has its uses, especially in larger applications. Paraphrasing
[Martin Fowler's article](http://martinfowler.com/eaaDev/uiArchs.html) somewhat:

- MVC gives 'Separated Presentation'
- Model objects are completely ignorant of the UI.
- Views are instances of a UI presentation
- The Controller's job is to take the user's input and figure out what to do with it

To fit into Slim 3's new way of doing things, using a controller has changed a bit. In
the previous version of this library, your routing methods simply called controller::route
and let the controller->action get on with presenting something back to the user.

Slim 3 expects the routing to return a Response, and the router will do the display for you.
The Slim team have altered the Slim\Twig::render method to return a response. And hence
the Site\Controller::route method now returns a Response.

## Create a Controller

Extend your Controller from AbstractController.  Optionally overide the beforeAction()
and afterAction() methods if you need to.

### Create an action

For each route that you want you controller to be responsible for, write an action method.
The signature for an action method is

```public function <name>Action(array $params = [])```

e.g.

```public function logonAction(array $params = [])```

The `$params` array is that which is passed as the third parameter to the base route() method
and is usually filled by parameters sent in on the request.  However, its source is
the routes.php file.

You have access to the DIC via `$this->dic`.

When the base route() method is called, it is passed the Request and Response
objects, and these are available to you as `$this->request` and `$this->response` respectively.

The Action _may_ return a Response.  If it does, it will be used by the router to send
back the response to the client.  You can create and return a response in two ways:

* manipulate and return a derivative of `$this->response`
* call and return `$this->render` method which will create and return a derivative of `$this->response`.
The render method requires at a minimum, the name of a template file to render.  In the
supplied demo, this is a Twig template, and you only supply the action name minus a file suffix.

The full signature for render is `protected function render($action = null, array $data = [], $status = null, $controller = null)`

You can negate the need to use the `$data` parameter by directly setting view data into `$this->viewData`.
 The default `$status` is 200, and the default `$controller` is the current one.
 
If your action does not return a response (i.e. no return statement,) then the route() method
will attempt to render a template which has the same name as action just executed for the current
controller.  Therefore, your action method just needs to set values in `$this->viewData` 
in order to be valid, and of course you need to create the Twig template file.

As an absolute backstop, if all your action would do is to display the Twig template,
then you can dispense with the action method altogether and just supply the Twig template.
 You can see this in action for the IndexCOntroller::index action.  No actual action method,
 just the Twig template in Site\View\index\index.twig.
 
### Create the DI container entry

You could instantiate your controller directly in the routes.php file, but that is not
much fun, and it is why you have Dependency Injection in the first place.  So edit the
Site/cfg/dic.base.controllers.xml file and add a service entry for your new controller.
The \__constructor signature is `public function __construct(ContainerInterface $dic, array $config = [])`.
Thus you can pass in additional configuration such as other services on construction.
Take a look at how the IndexController and SecurityCOntroller differ to get a handle on that.

By convention service ids are prefixed `controller.`

### Route to your controller

Lets say you've created a FooController.  It has an indexAction that simply displays
a Twig template, a fooAction that can be be reached via GET or POST and in the case
 of the latter, will have 'uid' form field value, and a barAction via GET that has query
  parameters.  Then you may have something like the following in the routes.php file:
  
<pre>
$app->get('/foo',
    function ($request, $response) {
        return $this->get('controller.foo')->route('foo', $request, $response);
    }
)
    ->setName('foo');
    
$app->post('/foo',
    function ($request, $response) {
        return $this->get('controller.foo')->route('foo', $request, $response, $request->getParsedBody());
    }
);

$app->get('/bar/{name}',
    function ($request, $response, $params) {
        return $this->get('controller.foo')->route('bar', $request, $response, $params);
    }
)
    ->setName('bar');

</pre>

Please note that the separation of the GET and POST at the routing level is purely
arbitrary.  You could have your controller::action method determine what to do based on
the request, in which case you might have something like:

<pre>
$app->map(['GET', 'POST'], '/foo',
    function ($request, $response) {
        return $this->get('controller.foo')->route('foo', $request, $response);
    }
)
    ->setName('foo');

</pre>

In which case, your controller::action must decide what to do and how to get its parameters
if it requires them.

Decide what works best for yourself, and stick to the convention you decide on.

[Back to Index](https://github.com/the-matrix/Slim-Dic-Example/blob/master/README.md)