<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 2/28/2015
 * Time: 1:41 PM
 */

class FormData extends Eloquent{
    protected $table = 'FormData';

    protected $primaryKey = 'FormDataID';

    public $timestamps = false;

    public function id(){
        return $this->FormDataID;
    }

    public function __toString()
    {
        return $this->Value;
    }
}