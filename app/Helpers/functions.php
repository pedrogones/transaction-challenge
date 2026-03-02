<?php

if(!function_exists('formatValueCurrencyBr')){
    function formatValueCurrencyBr(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }
}
if(!function_exists('secureRole')){
    function secureRole($role): string
    {
        return $role->name == "Admin" || $role->name == "User" || $role->name == "Adminstrador";
    }
}
