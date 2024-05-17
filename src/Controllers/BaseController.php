<?php
namespace Project\Controllers;

use Project\Validator;

class BaseController
{
    public Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }
}