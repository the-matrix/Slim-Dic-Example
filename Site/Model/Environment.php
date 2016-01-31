<?php
/*
 * The-Matrix Demonstration App for Slimdic
 *
 * Site Controllers
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 */
namespace Site\Model;

/**
 * Static class environment definitions
 */
abstract class Environment
{
    /**
     * Live production enviroment
     */
    const ENVSTATE_PRODUCTION = 'production';

    /**
     * Staging environment
     */
    const ENVSTATE_STAGING = 'staging';

    /**
     * UAT environment
     */
    const ENVSTATE_UAT = 'uat';
    
    /**
     * QA Test environment
     */
    const ENVSTATE_QA = 'qa';

    /**
     * Development environment
     */
    const ENVSTATE_DEV = 'development';
    
    /**
     * Unit test environment
     */
    const ENVSTATE_UNIT_TEST = 'unittest';

    /**
     * Known valid environemnt states
     *
     * @var array
     */
    private static $environmentStates = array(
        self::ENVSTATE_PRODUCTION,
        self::ENVSTATE_STAGING,
        self::ENVSTATE_UAT,
        self::ENVSTATE_QA,
        self::ENVSTATE_DEV,
        self::ENVSTATE_UNIT_TEST
    );

    /**
     * The current environment state
     *
     * @var string
     */
    private static $currentEnvironmentState;

    /**
     * Return the environment state
     *
     * You can set a different application environment by setting
     * it in the vhost or .htaccess file e.g.
     * SetEnv APPLICATION_ENV development
     *
     * The standard environments are defined in the ENVSTATE_...
     * constants of this class.  You cannot set an environment state that
     * is not declared in one of these constants
     *
     * The default if not set == ENVSTATE_PRODUCTION
     *
     * @return string
     */
    final public static function getEnvironmentState()
    {
        if (empty(self::$currentEnvironmentState)) {
            if (defined('APPLICATION_ENV')) {
                $state = APPLICATION_ENV;
            } else {
                // @codeCoverageIgnoreStart
                if (getenv('APPLICATION_ENV')) {
                    $state = getenv('APPLICATION_ENV');
                } else {
                    $state =  self::ENVSTATE_PRODUCTION;
                }
                // @codeCoverageIgnoreEnd
            }

            self::$currentEnvironmentState = (
                    self::isValidEnvironmentState($state)
                    ? $state
                    : self::ENVSTATE_PRODUCTION);
        }

        return self::$currentEnvironmentState;
    }

    /**
     * Check if an environemnt state is a valid known state
     *
     * @param string $state
     * @return boolean
     */
    final public static function isValidEnvironmentState($state)
    {
        return (in_array($state, self::$environmentStates));
    }

    /**
     * Manually set the environment state
     *
     * @param string $state
     * @throws FirstUtility\Environment\Exceptions\InvalidParameterException
     */
    final public static function setEnvironmentState($state)
    {
        if (self::isValidEnvironmentState($state)) {
            self::$currentEnvironmentState = $state;
        } else {
            throw new InvalidParameterException($state);
        }
    }
}


