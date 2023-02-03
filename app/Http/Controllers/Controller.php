<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function returnFailedResponse($responseCode, $responseBody){
        switch($responseCode){
            case 401:
                return redirect()->back()->withInput()->withError(__('auth.'.$responseBody->error));
            case 403:
                return redirect()->back()->withInput()->withError('Forbidden');
            case 404:
                return redirect()->back()->withInput()->withError('Service Not Found');
            case 422:
                return redirect()->back()->withInput()->withErrors($responseBody->errors);
            default:
                break;
        }
    }
}
