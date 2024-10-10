<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityInspection extends Model
{
    use HasFactory;
    protected $table = 'tbl_facinspect';
    protected $primaryKey = 'inspection_id';
    protected $fillable = ['inspection_date', 'fac_id', 'inspector_name', 'inspection_date', 'inspection_status', 'reinspection_status', 'reinspection_date', 'inspection_form', 'inspection_type', 'reject_remarks', 'date_successful', 'late_remarks'];
    public $timestamps = false;
    public function initialinspection(){
        return $this->hasOne(InitialApplications::class, 'inspection_id', 'inspection_id');
    }
    public function operationinspection(){
        return $this->hasOne(OperationalApplications::class, 'inspection_id', 'inspection_id');
    }
    public function facility(){
        return $this->belongsTo(Facility::class, 'fac_id', 'fac_id');
    }
}
