<?php
/**
 * purifier.php
 *
 * PHP version 7
 *
 * @category    Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
