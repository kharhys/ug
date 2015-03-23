<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 3/5/2015
 * Time: 2:30 PM
 */

class Invoice extends \Eloquent {
    protected $table = 'InvoiceHeader';

    protected $primaryKey = 'InvoiceHeaderID';

    public function id()
    {
        return $this->InvoiceHeaderID;
    }

    public function items()
    {
        return $this->hasMany('InvoiceLine','InvoiceHeaderID');
    }

    public function business()
    {
        return $this->belongsTo('Business','CustomerID');
    }

    public function total()
    {
        return $this->items->sum('Amount');
    }

    public function payments()
    {
        return $this->hasMany('Receipt','InvoiceHeaderID');
    }


    public function paid()
    {
        return $this->payments()->sum('Amount');
    }

    public function balance()
    {
        $amount = $this->paid();
        $required = $this->total();
        return $required-$amount;
    }
}
