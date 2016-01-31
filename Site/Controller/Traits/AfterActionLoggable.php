<?php
/**
 * the-matrix-slim-dic-example
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license GPL V3+ See LICENSE.md
 */
namespace Site\Controller\Traits;

/**
 * AfterActionLoggable
 * Simple controller after action to log what action was done
 * You'll need to set the log level to info to see this
 * @see Site/cfg/dic.base.logging.xml
 */
trait AfterActionLoggable
{

    protected function afterAction()
    {
        $this->dic->get('app.logger')->addInfo('Executed: ' . $this->controllerName() . '/' . $this->actionName());
    }
}