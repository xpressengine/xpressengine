<?php

return [
    'encoding' => 'UTF-8',
    'finalize' => false,
    'cachePath' => storage_path('framework/htmlpurifier/middleware'),
    'settings' => [
        'default' => [
            'Core.RemoveInvalidImg' => false,
            'HTML.AllowedModules' => 'CommonAttributes,Hypertext,Image,List,StyleAttribute,Tables'.
                ',Text,Structure,Legacy,NonXMLCommonAttributes,XMLCommonAttributes,TargetBlank,Presentation',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty' => true
        ]
    ],
];
