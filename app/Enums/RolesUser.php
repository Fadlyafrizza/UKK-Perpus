<?php

namespace App\Enums;

enum RolesUser: string
{
    case ADMIN = 'administrator';
    case PETUGAS = 'petugas';
    case USER = 'peminjam';
}
