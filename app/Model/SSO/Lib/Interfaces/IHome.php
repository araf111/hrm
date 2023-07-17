<?php


namespace App\Model\SSO\Lib\Interfaces;


use Illuminate\Http\Request;

interface IHome
{
    public function getUserData(Request $request);

}