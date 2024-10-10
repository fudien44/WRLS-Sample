<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OperationalApplications extends Model
{
    use HasFactory;
    protected $table = 'tbl_operatepplication';
    protected $primaryKey = 'operateapp_id';

    protected $fillable = ['fac_id', 'user_id', 'submission_date','operatectrl_no', 'reject_remarks', 'application_status', 'late_remarks', 'inspector_date_action', 'inspector_date_reaction', 'late_date', 'inspection_id', 'inspector_date_rejected'];

    public $timestamps = false;

    // protected $fillable = ['operateapp_id', 'fac_id', 'user_id', 'submission_date', 'reject_remarks', 'application_status', 'late_remarks', 'inspector_date_action', 'inspector_date_reaction', 'late_date', 'inspection_id', 'inspector_date_rejected'];
    // public function Client()
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function facilityInfo():BelongsTo
    {
        return $this->belongsTo(Facility::class, 'fac_id', 'fac_id');
    }
    public function operattach():HasOne
    {
        return $this->hasOne(OperAttachment::class, 'operateapp_id', 'operateapp_id');
    }
    public function operatePermit():HasOne
    {
        return $this->hasOne(OperationalPermit::class, 'operateapp_id', 'operateapp_id');
    }
}
