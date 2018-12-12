<?php
if (!function_exists('asset_path')) {
    function asset_path($module,$file)
    {
        return asset('app/Modules/'.$module.'/Resources/assets/'.$file);
    }
}
