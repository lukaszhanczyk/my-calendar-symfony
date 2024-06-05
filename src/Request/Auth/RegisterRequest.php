<?php

namespace App\Request\Auth;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterRequest extends BaseRequest
{
    #[Email]
    #[NotBlank]
    public $email;

    #[Type('string')]
    #[NotBlank]
    public $password;

    #[Type('string')]
    #[NotBlank]
    #[IdenticalTo(propertyPath: 'password', message: 'Passwords should be the same')]
    public $verify_password;
}