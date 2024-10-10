<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['lname', 'fname', 'email', 'password', 'contactno'];
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}
