<?php

class ServiceHeader extends \Eloquent {

    protected $table = 'ServiceHeader';

    protected $primaryKey = 'ServiceHeaderID';

    public $timestamps = false;

    public function id()
    {
        return $this->ServiceHeaderID;
    }


}
