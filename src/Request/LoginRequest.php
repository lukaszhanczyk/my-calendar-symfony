<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class LoginRequest extends BaseRequest
{
    #[Email]
    #[NotBlank]
    public $username;

    #[Type('string')]
    #[NotBlank]
    public $password;

}