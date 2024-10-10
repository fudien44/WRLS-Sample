<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperAttachment extends Model
{
    use HasFactory;

    protected $table = 'tbl_operateattachment';

    protected $primaryKey = 'operattach_id';
    protected $fillable = ['operateapp_id','application_form', 'letter_intent', 'cert_completion', 'cert_pot', 'cert_training', 'xerox_init_permit', 'is_application_form_validated', 'is_letter_intent_validated', 'is_cert_completion_validated', 'is_cert_pot_validated', 'is_cert_training_validated', 'is_xerox_init_permit_validated'];

    
    public $timestamps = false;
    public function operateApplication():BelongsTo
    {
     return $this->belongsTo(OperationalApplications::class, 'operateapp_id','operateapp_id' );
    }
      

    
}
