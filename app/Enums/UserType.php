<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    #[Description('Admin')]
    const Administrator = 0;
    const Custumer = 1;
    const Editor = 2;
    const Manager = 3;

}
