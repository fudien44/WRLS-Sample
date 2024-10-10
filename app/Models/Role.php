<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $fillable = ['rolename'];
    protected $primaryKey = 'role_id';
    public $incrementing = false;

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'role_id', 'role_id');
    }
}