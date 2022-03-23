<?php

namespace App\Repositories\Enums;

enum GetUserBy: string {
    case EMAIL = 'email';
    case USERNAME = 'username';
    case ID = 'id';
}