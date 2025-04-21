<?php
namespace App\Enums;

enum UserRole: string
{
    case Member = 'member';
    case Leader = 'leader';
    case Superadmin = 'superadmin';
}