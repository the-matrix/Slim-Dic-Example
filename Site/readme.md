# Site directory

This directory acts as a the namespaced root for Site specific application 
artifacts and is referenced in the composer.json file namespacing.

In the root of this directory is run.php - this is the real runner for your site.
/public/index.php just includes this file. And it does so that the real runnable
code is outside of public inspection. - security peeps, security.

Routing is is routes.php

## Controller

Site controllers go in this directory with a namespace of Site\Controller

## Model

Site Models go in this directory with a namespace of Site\Model

## View

View scripts go in this directory.  These are not namespaced in a PHP sense.
However the Slimdic\Controller\AbstractController render() method expects to find
scripts in certain places by convention.  Within the View folder, there is a 
subfolder with the name of each controller minus the 'Controller' suffix, and in
lowercase.  e.g. Site\Controller\IndexController -> Site/View/index.  Put your view scripts
in the specific controller subdirectories.  e.g. for IndexController::indexAction you
would probably have Site/View/index/index.twig.

## cfg

Contains all the DIC definitions for the site.

*  dic.base.controllers.xml -> controller definitions. By convention, begin 
the service name with 'controller.'

*  dic.base.factory.xml -> any generic factory services used by the DI.  Mark these as
non public

*  dic.base.logging.xml -> application logger definition

*  dic.base.models.xml -> model definitions.  The actual classes don't have to 
be in the Site\Model directory, but by convention, begin the service name with 'model.'

*  dic.base.view.xml -> Slim view definition.  In this application, we use the Twig
view, but you can define your own. (NB, you may have to do some work in the AbstractController::render()
method, if you do change the view technology.)

*  dic.slim.xml -> the Slim services definitions required to support Slim in the DI container

*  parameters.slim.yml -> parameters used by dic.slim.xml

*  dic.production.xml -> the basic production ready DI
    * imports all the base xml service definitions
    * imports parameters.production.yml params file

*  dic.development.xml -> development version of DI.  Override definitions here for development
    * imports dic.production.xml
    * imports parameters.development.yml to override some production parameter values

If you use other environment modes (allowed by Site\Model\Environment,) then you will need
to create a dic.\<mode\>.xml file (and a parameters.\<mode\>.yml file if required,) to match.  
It can simply import the production di definition, or override and extend as necessary.

Remember: Keep your DI definitions  `public="false"` unless you really mean for
them to be accessible to the application

[Back to Index](https://github.com/the-matrix/Slim-Dic-Example/blob/master/README.md)