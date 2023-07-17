<?php


namespace App\Model\SSO\Lib\Interfaces;


use Illuminate\Http\Request;

interface ISSOAppLogin
{
    public function getLandingUrl(Request $request);
}