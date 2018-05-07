<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller {

    const HTTP_OK    = 200;
    const HTTP_ERROR = 500;

    public function success()
    {
        return response('OK', self::HTTP_OK);
    }

    public function error($message)
    {
        return response($message, self::HTTP_ERROR);
    }

}
