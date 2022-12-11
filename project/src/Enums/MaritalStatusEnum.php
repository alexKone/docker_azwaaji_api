<?php

namespace App\Enums;

enum MaritalStatusEnum: string
{
    case MARRIED = "married";
    case DIVORCED = "divorced";
    case CELIBATE = "celibate";
    case WIDOWER = "widower";
}
