<?php

if (!function_exists('hasModuleAccess')) {
    function hasModuleAccess($moduleName)
    {
        $userModules = explode(",", json_decode(auth()->user()->role->module, true));
        return in_array($moduleName, $userModules);
    }
}
