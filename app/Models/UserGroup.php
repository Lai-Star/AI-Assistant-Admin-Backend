<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'company_id',
        'member_cnt',
        'created_by',
    ];
    protected $table = 'user_groups';
}
