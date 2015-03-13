<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 3/5/2015
 * Time: 2:40 PM
 */

class InvoiceLine extends \Eloquent{

    protected $table = 'InvoiceLines';

    protected $primaryKey = 'InvoiceLineID';

    public function id()
    {
        return $this->InvoiceLineID;
    }

    public function invoice()
    {
        return $this->belongsTo('Invoice','InvoiceHeaderID');
    }

    public function application()
    {
        return $this->belongsTo('Application','ServiceHeaderID');
    }
}