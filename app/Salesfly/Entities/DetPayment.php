<?php
namespace Salesfly\Salesfly\Entities;

class DetPayment extends \Eloquent {

	protected $table = 'detPayments';
    
    protected $fillable = ['fecha','payment_id','tipoPago','methodPayment_id','montoPagado'];

}