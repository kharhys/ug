<?php

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

    protected $table = 'Customer';

    protected $primaryKey = 'CustomerID';

    public $timestamps = false;

    public function id(){
        return $this->CustomerID;
    }

}
