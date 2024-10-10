<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_profile';

    protected $primaryKey = 'profile_id';

    protected $fillable = ['profile_id','user_id','firstname','mi','lastname','gender','address','city','barangay','bday','occupation','picture'];

    public function UserAccount(){
        return $this->hasOne(Client::class, 'user_id', 'user_id');
    }

    public function facility(){
        return $this->hasMany(Facility::class, 'user_id', 'user_id');
    }
}
