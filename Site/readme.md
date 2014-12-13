# Site directory

This directory acts as a the namespaced root for Site specific application 
artifacts and is referenced in the composer.json file namespacing.

Place in here all site specific files.  You can add sub-folders as you wish

## Controller

Site controllers go in this directory with a namespace of Site\Controller

## Model

Site Models go in this directory with a namespace of Site\Model

## View

View scripts go in this directory.  These are not namespaced in a PHP sense.
However the Slimdic\Controller\AbstractController render() method expects to find
scripts in certain places by convention.  Within the View folder, there is a 
subfolder with the name of each controller minus the 'Controller' suffix, and in
lowercase.  e.g. Site\Controller\IndexController -> Site/View/index

## cfg

Contains all the DIC definitions for the site.

*  dic.base.controllers.xml -> controller definitions. By convention, begin 
the service name with 'controller.'

*  dic.base.models.xml -> model definitions.  The actual classes don't have to 
be in the Site\Model directory, but by convention, begin the service name with 'model.'

*  dic.base.factory.xml -> any private factory DI definitions

*  dic.production.xml -> the basic production ready DI
    * imports dic.base.controllers.xml
    * imports dic.base.models.xml
    * imports dic.base.factory.xml

*  dic.development.xml -> development version of DI.  Override definitions here for development
    * imports dic.production.xml

If you use other environment modes (allowed by Slimdic\Environment,) then you will need
to create a dic.\<mode\>.xml file to match.  It can simply import the production
di definition, or override and extend as necessary.

Remember: Keep your DI definitions  `public="false"` unless you really mean for
them to be accessible to the application