<?php

namespace App\Models;

use App\Models\OperationalApplications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperationalPermit extends Model
{
    use HasFactory;

    protected $table = 'tbl_operationalpermit';
    protected $primaryKey = 'permit_id';
    protected $fillable = ['operateapp_id','operatectrl_no', 'operate_permit'];


    public function operateApplication():BelongsTo
    {
     return $this->belongsTo(OperationalApplications::class, 'operateapp_id','operateapp_id' );
    }
}
