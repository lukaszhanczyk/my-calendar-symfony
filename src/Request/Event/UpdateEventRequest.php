<?php

namespace App\Request\Event;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class UpdateEventRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank]
    public int $id;

    #[Type('string')]
    #[Length(max: 180)]
    #[NotBlank]
    public string $title;

    #[Type('string')]
    #[NotBlank]
    public string $description;

    #[Type('string')]
    #[NotBlank]
    public string $date;

    #[Type('string')]
    #[Length(max: 32)]
    #[NotBlank]
    public string $color;

    #[Type('integer')]
    #[NotBlank]
    public int $user_id;

}