<?php

namespace App\Enums;

enum UserApiAccessLevelEnum {
    case READ_ONLY;
    case READ_WRITE;
    case FULL_ACCESS;
}