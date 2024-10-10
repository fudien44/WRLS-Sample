<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class opctrlno extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_opctrlno';
    protected $primaryKey = 'id';
    protected $fillable = ['fac_id', 'year', 'number'];

    public function facilityInfo():BelongsTo
    {
        return $this->belongsTo(Facility::class, 'fac_id', 'fac_id');
    }
}
