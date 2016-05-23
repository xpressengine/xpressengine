<?php

if (!function_exists('editor')) {
    function editor($instanceId, $arguments)
    {
        return app('xe.editor')->get($instanceId)->setArguments($arguments)->render();
    }
}
