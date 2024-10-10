<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InitAttachment extends Model
{
    use HasFactory;

    protected $table = 'tbl_initattachment';
    protected $primaryKey = 'initattach_id';
    protected $fillable = [
        'initapp_id',
        'is_validated',
        'application_form',
        'cert_pot',
        'sanitary_survey',
        'watersite_clearance',
        'engineers_report',
        'plans_specs',
        'is_application_form_validated',
        'is_cert_pot_validated',
        'is_sanitary_survey_validated',
        'is_watersite_clearance_validated',
        'is_engineers_report_validated',
        'is_plans_specs_validated',
    ];
    public $timestamps = false;
    public function initialApplication():BelongsTo
    {
        return $this->belongsTo(InitialApplication::class, 'initapp_id', 'initapp_id');
    }

     
}
