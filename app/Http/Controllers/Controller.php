<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware(function($request,$next){
        //     if (session('success')) {
        //         Alert::success(session('success'));
        //     }

        //     if (session('error')) {
        //         Alert::error(session('error'));
        //     }
        //     if (session('errorForm')) {
        //         $html = "<ul style='list-style: none;'>";
        //         foreach(session('errorForm') as $error) {
        //             $html .= "<li>$error[0]</li>";
        //         }
        //         $html .= "</ul>";

        //         Alert::html('Peringatan !!', $html, 'error');
        //     }

        //     return $next($request);
        // });
    }

}
