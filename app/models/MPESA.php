<?php
/**
 * Created by PhpStorm.
 * User: SSL
 * Date: 3/6/2015
 * Time: 1:02 PM
 */

class MPESA extends  \Eloquent{

    protected $table= 'mpesa';

    protected $primaryKey = 'id';

   public function scopeFindByAccount($query,$account_no)
   {
       return $query->where('mpesa_acc','=',$account_no);
   }


}