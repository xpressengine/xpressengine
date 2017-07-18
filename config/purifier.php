<?php

return [
    'encoding' => 'UTF-8',
    'finalize' => true,
    'cachePath' => storage_path('framework/htmlpurifier/middleware'),
    'settings' => [
        'default' => [
            'Core.RemoveInvalidImg' => false,
            'HTML.AllowedModules' => 'CommonAttributes,Hypertext,Image,List,StyleAttribute,Tables'.
                ',Text,Structure,Legacy,NonXMLCommonAttributes,XMLCommonAttributes',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty' => true
        ]
    ],
];
