<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{

    use HasFactory;

    protected $table = 'tbl_orderpayment';
    protected $primaryKey = 'orderpayment_id';
    protected $fillable = ['initapp_id','order_payment', 'attach_OR', 'is_order_payment_validated', 'is_attach_OR_validated'];

    public function initialApplication():BelongsTo
    {
        return $this->belongsTo(InitialApplication::class, 'initapp_id', 'initapp_id');
    }

}
