<?php


namespace App\Model\SSO\Lib\Interfaces;

use Illuminate\Http\Request;

interface ISSOLogin
{
    public function getRedirectUrl(Request $request);
}