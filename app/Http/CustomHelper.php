<?php

if (!function_exists('asset')) {
    function asset($path, $secure = null)
    {
        // Your custom implementation here
        // You can call the original asset function if needed
        // return \Illuminate\Support\Facades\URL::asset($path, $secure);

        // Or implement your own logic
        return 'public/' . $path;
    }
}