<?php

namespace App\Models;

/**
* OnLine model
* @author Masterton
* @version 1.0.0
* @time 2017-12-13 10:44:31
*
*/
class OnLine extends Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'on_line';
    /**
     * Indicates if the model should be timestamped.
     * @var bool
     */
    public $timestamps = true;
    protected $datas = ['deleted_at'];
}