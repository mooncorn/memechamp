<?php

namespace App\Models;

use App\Helpers\DBConnection;

class Competition
{
    public static function fetchActive() {
        return DBConnection::getDB()->query("SELECT id FROM competition WHERE is_active=true")->fetch();
    }
}