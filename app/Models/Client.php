<?php

namespace App\Models;

use App\Models\InitialApplications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'role',
        'email',
        'password',
        'contact_no'
    ];
    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';

    public function init(){
        return $this->belongsTo(UserProfile::class, 'user_id');
    }

    public function initapplications()
    {
        return $this->hasMany(InitialApplication::class, 'user_id');
    }

    public function opapplications()
    {
        return $this->hasMany(OperationalApplications::class, 'user_id');
    }
}
