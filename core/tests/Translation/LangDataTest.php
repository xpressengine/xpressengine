<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Translation\LangData;

class LangDataTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testLangData()
    {
        $data = [
            'previous' => [
                'ko' => '이전',
                'en' => 'Prev',
            ],
            'next' => [
                'ko' => '다음',
                'en' => 'Next',
            ],
            'week' => [
                'mon' => [
                    'ko' => '월',
                    'en' => 'monday',
                ],
                'tue' => [
                    'ko' => '화',
                    'en' => 'tueseday',
                ],
            ],
        ];

        $expectedData = [
            'previous' => [
                'ko' => '이전',
                'en' => 'Prev',
            ],
            'next' => [
                'ko' => '다음',
                'en' => 'Next',
            ],
            'week.mon' => [
                'ko' => '월',
                'en' => 'monday',
            ],
            'week.tue' => [
                'ko' => '화',
                'en' => 'tueseday',
            ],
        ];

        $retrievedData = [];

        $langData = new LangData();
        $langData->setData($data);
        $langData->each(function ($item, $locale, $value) use (&$retrievedData) {
            $retrievedData[$item][$locale] = $value;
        });

        $this->assertSame($expectedData, $retrievedData);
    }
}
