<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InitialApplications extends Model
{
    use HasFactory;
    protected $table = 'tbl_initapplication';
    protected $primaryKey = 'initapp_id';
    protected $fillable = ['initapp_id', 'fac_id', 'user_id', 'submission_date', 'reject_remarks', 'application_status', 'late_remarks', 'inspector_date_action', 'inspector_date_reaction', 'late_date', 'inspection_id', 'inspector_date_rejected'];
    public function Client()
    {
        return $this->belongsTo(Client::class, 'user_id', 'user_id');
    }

    public function InspectionDate()
    {
        return $this->belongsTo(FacilityInspection::class, 'inspection_id', 'inspection_id');
    }
}
