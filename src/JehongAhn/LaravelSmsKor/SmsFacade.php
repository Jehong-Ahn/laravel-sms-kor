<?php namespace JehongAhn\LaravelSmsKor;

use Illuminate\Support\Facades\Facade;

class SmsFacade extends Facade {
 
    protected static function getFacadeAccessor() {
        return 'sms';
    }
 
}