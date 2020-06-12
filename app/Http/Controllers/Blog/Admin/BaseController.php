<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;


/**
 * Class BaseController
 * @package App\Http\Controllers\Blog\Admin
 */
abstract class BaseController extends GuestBaseController
{
    /**
    BaseController constructor.
     */

    public function __construct()
    {
        //Common moments of admin.
    }

}
