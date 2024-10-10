<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;
    protected $table = 'tbl_facility';
    protected $primaryKey = 'fac_id';
    protected $fillable = ['user_id', 'fac_name', 'fac_licenseno', 'fac_telphone_no', 'fac_address', 'latitude', 'longitude', 'area_to_serve', 'water_source_type', 'operation_status', 'initial_permit', 'operation_permit', 'owner_name', 'owner_address', 'phone_number', 'telephone_number', 'license_expiry'];
    public $timestamps = false;

    public function initialApplication(): HasOne
    {
        return $this->hasOne(InitialApplication::class, 'fac_id', 'fac_id');
    }

    public function opctrlno(): HasOne
    {
        return $this->hasOne(opctrlno::class, 'fac_id', 'fac_id');
    }

    public function operateApplication(): HasOne
    {
        return $this->hasOne(OperationalApplications::class, 'fac_id', 'fac_id');
    }
    public function facilityinspection(){
        return $this->hasMany(FacilityInspection::class, 'fac_id', 'fac_id');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    
}
