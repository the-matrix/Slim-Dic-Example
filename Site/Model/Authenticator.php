<?php
/*
 * The-Matrix Demonstration App for Slimdic 
 * 
 * Site Controllers
 * 
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2014, UK
 */
namespace Site\Model;

use Chippyash\Type\String\StringType;

/**
 * Demo authenticator
 */
class Authenticator
{
    public function authenticate(StringType $uid, StringType $pwd)
    {
        return $uid() == 'user' && $pwd() == 'password';
    }
}
