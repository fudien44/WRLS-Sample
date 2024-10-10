<?php

namespace App\Models;

use App\Models\InitialApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InitialPermit extends Model
{
    use HasFactory;

    protected $table = 'tbl_initialpermit';
    protected $primaryKey = 'permit_id';
    protected $fillable = ['initapp_id','initial_permit'];

    public function initialApplication():BelongsTo
    {
        return $this->belongsTo(InitialApplication::class, 'initapp_id', 'initapp_id');
    }
}
