<?php

namespace App\Member\Application\Auth;

use Symfony\Component\Validator\Constraints as Assert;

class LoginFormModel
{
    #[Assert\NotBlank]
    public ?string $email = null;

    #[Assert\NotBlank]
    public ?string $password = null;
}
