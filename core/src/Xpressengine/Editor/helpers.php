<?php

if (!function_exists('editor')) {
    function editor($instanceId, $arguments)
    {
        return app('xe.editor')->get($instanceId)->setArguments($arguments)->render();
    }
}

if (!function_exists('compile')) {
    function compile($instanceId, $content)
    {
        return app('xe.editor')->compile($instanceId, $content);
    }
}
