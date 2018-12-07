<?php
/**
 * purifier.php
 *
 * PHP version 7
 *
 * @category    Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

return [
    'encoding' => 'UTF-8',
    'finalize' => false,
    'cachePath' => storage_path('framework/htmlpurifier/middleware'),
    'settings' => [
        'default' => [
            'Core.RemoveInvalidImg' => false,
            'HTML.AllowedModules' => 'CommonAttributes,Hypertext,Image,List,StyleAttribute,Tables'.
                ',Text,Structure,Legacy,NonXMLCommonAttributes,XMLCommonAttributes,TargetBlank,Presentation',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => true,
            'HTML.TargetBlank' => true
        ]
    ],
];
