<?php
if (!function_exists('asset_path')) {
    function asset_path($module,$file)
    {
        $tbl = explode('/',$file);
        return asset($tbl[0].'/'.$module.'/'.$tbl[1]);
    }
}
