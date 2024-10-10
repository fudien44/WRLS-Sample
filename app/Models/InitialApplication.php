<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InitialApplication extends Model
{
    use HasFactory;

    protected $table = 'tbl_initapplication';
    protected $primaryKey = 'initapp_id';
    protected $fillable = [
        'initapp_id', 
        'fac_id', 
        'user_id', 
        'submission_date', 
        'reject_remarks', 
        'application_status', 
        'late_remarks', 
        'inspector_date_action', 
        'inspector_date_reaction', 
        'late_date', 
        'inspection_id', 
        'inspector_date_rejected',
        'is_paid'
    ];
    public $timestamps = false;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function facilityInfo(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'fac_id', 'fac_id');
    }

    public function initAttach(): HasOne
    {
        return $this->hasOne(InitAttachment::class, 'initapp_id', 'initapp_id');
    }

    public function inspectionDate(): BelongsTo
    {
        return $this->belongsTo(FacilityInspection::class, 'inspection_id', 'inspection_id');
    }

    public function orderPayment(): HasOne
    {
        return $this->hasOne(OrderPayment::class, 'initapp_id', 'initapp_id');
    }
    public function initialPermit(): HasOne
    {
        return $this->hasOne(InitialPermit::class, 'initapp_id', 'initapp_id');
    }
}
