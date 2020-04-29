<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

include "TranslationTestCase.php";

use Mockery as m;

class TranslatorTest extends TranslationTestCase
{
    private $t = null;

    protected function tearDown()
    {
        m::close();
        $this->t = null;
    }

    protected function setUp()
    {
        $this->t = $this->createTranslator
        (
            [
                'locales' => ['en', 'ko'],
                'localeTexts' => [
                    'ko' => '대한민국',
                    'en' => 'U.S.',
                ]
            ],
            [
                'source_1.php' => [
                    'previous' => [
                        'en' => 'Prev',
                        'ko' => '이전',
                    ],
                    'next' => [
                        'en' => 'Next',
                        'ko' => '다음',
                    ],
                    'week' => [
                        'mon' => [
                            'en' => 'monday',
                            'ko' => '월',
                        ],
                        'tue' => [
                            'en' => 'tueseday',
                            'ko' => '화',
                        ],
                    ],
                ],

                'source_2.php' => [
                    'welcome' => [
                        'en' => 'Hi, :name!',
                        'ko' => '안녕, :name!',
                    ],
                    'choice' => [
                        'en' => '{0} There is none|[1,19] There are some|[20,Inf] There are many',
                        'ko' => '{0} 없습니다|[1,19] 조금 있습니다|[20,Inf] 많이 있습니다',
                    ],
                    'replacements' => [
                        'en' => ':long! :longer!',
                        'ko' => ':long! :longer!',
                    ],
                ],

                'source_3.php' => [
                    'welcome' => [
                        'en' => 'Welcome, :name!',
                        'ko' => ':name님 환영합니다!',
                    ],
                ],

            ]
        );

        $this->t->setLocales(['en', 'ko']);
        $this->t->putFromLangDataSource('namespace', 'source_1.php');

        $this->t->putFromLangDataSource('test', 'source_2.php', 'file');
        $this->assertEquals('Hi, :name!', $this->t->trans('test::welcome'));

        $this->t->putFromLangDataSource('test', 'source_3.php', 'unknown');
        $this->assertEquals('Welcome, :name!', $this->t->trans('test::welcome'));
    }

    public function testTrans()
    {
        $this->assertEquals('unknown', $this->t->trans('test::unknown'));
        $this->assertEquals('Welcome, :name!', $this->t->trans('test::welcome'));
        $this->assertEquals('Welcome, XE3!', $this->t->trans('test::welcome', ['name' => 'XE3']));
        $this->assertEquals('msg! message!', $this->t->trans('test::replacements', ['long' => 'msg', 'longer' => 'message']));

        $this->assertEquals('monday', $this->t->trans('namespace::week.mon'));
        $this->assertEquals('monday', $this->t->trans('namespace::week.mon', [], 'en'));
        $this->assertEquals('월', $this->t->trans('namespace::week.mon', [], 'ko'));

        $this->assertEquals('There is none', $this->t->transChoice('test::choice', 0));
        $this->assertEquals('There are some', $this->t->transChoice('test::choice', 1));
        $this->assertEquals('There are some', $this->t->transChoice('test::choice', 19));
        $this->assertEquals('There are many', $this->t->transChoice('test::choice', 20));
        $this->assertEquals('There are many', $this->t->transChoice('test::choice', 9999));
    }

    /**
     * @expectedException Exception
     */
    public function testLocales()
    {
        $this->assertEquals('en', $this->t->getLocale());

        $this->t->setLocale('unknown');
        $this->assertEquals('en', $this->t->getLocale());

        $this->assertEquals(['en', 'ko'], $this->t->getLocales());

        $this->t->setLocale('ko');
        $this->assertEquals('ko', $this->t->getLocale());
        $this->assertEquals(['ko', 'en'], $this->t->getLocales());

        $this->t->setLocales([]);
        $this->t->setLocale('en');
        $this->assertEquals('en', $this->t->getLocale());
        $this->assertEquals(['en'], $this->t->getLocales());
    }

    public function testGetOriginalLine()
    {
        $this->t->setLocale('en');
        $this->assertEquals('Welcome, :name!', $this->t->getOriginalLine('test::welcome'));
        $this->t->setLocale('ko');
        $this->assertEquals(':name님 환영합니다!', $this->t->getOriginalLine('test::welcome'));
    }

    public function testGenUserKey()
    {
        $this->assertEquals(strlen($this->t->genUserKey()), strlen('user::') + 36);
        $this->assertNotEquals($this->t->genUserKey(), $this->t->genUserKey());
    }

    public function testSave()
    {
        $this->assertEquals('message', $this->t->trans('temp::message'));
        $this->t->save('temp::message', 'en', 'A temp message~!');
        $this->assertEquals('A temp message~!', $this->t->trans('temp::message'));

        $this->assertEquals('message', $this->t->trans('message'));
        $this->t->save('message', 'en', 'A temp message~!');
        $this->assertEquals('A temp message~!', $this->t->trans('message'));
    }
}
