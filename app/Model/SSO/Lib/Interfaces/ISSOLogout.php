<?php


namespace App\Model\SSO\Lib\Interfaces;


use Illuminate\Http\Request;

interface ISSOLogout
{
    public function getRedirectUrl(Request $request);
}