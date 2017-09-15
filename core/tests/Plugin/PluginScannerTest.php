<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginScanner;

class PluginScannerTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $dir    = __DIR__.'/plugins';
        $reader = $this->getReaderMock($dir);

        $scanner = new PluginScanner($reader, $dir);

        $this->assertInstanceOf('Xpressengine\Plugin\PluginScanner', $scanner);

        return $scanner;
    }

    /**
     * @depends testConstruct
     *
     * @param PluginScanner $scanner
     */
    public function testScanDirectory($scanner)
    {
        $pluginsInfos = $scanner->scanDirectory();

        $this->assertEquals(2, count($pluginsInfos));

        $this->assertEquals('Xpressengine\Tests\Plugin\Sample\PluginSample', $pluginsInfos['plugin_sample']['class']);
        $this->assertEquals(
            'khongchi/plugin_sample',
            $pluginsInfos['plugin_sample']['metaData']['name']
        );
        $this->assertEquals('Xpressengine\Tests\Plugin\Sample\PluginSample2', $pluginsInfos['plugin_sample2']['class']);
        $this->assertEquals(
            'khongchi/plugin_sample2',
            $pluginsInfos['plugin_sample2']['metaData']['name']
        );
    }

    /**
     * @depends testConstruct
     *
     * @param PluginScanner $scanner
     */
    public function testScanDirectorySpecificPlugin($scanner)
    {
        $pluginsInfos = $scanner->scanDirectory('plugin_sample2');

        $this->assertEquals(1, count($pluginsInfos));

        $this->assertEquals('Xpressengine\Tests\Plugin\Sample\PluginSample2', $pluginsInfos['plugin_sample2']['class']);
        $this->assertEquals(
            'khongchi/plugin_sample2',
            $pluginsInfos['plugin_sample2']['metaData']['name']
        );
    }

    /**
     * @depends testConstruct
     * @expectedException \Xpressengine\Plugin\Exceptions\PluginNotFoundException
     * @param PluginScanner $scanner
     */
    public function testScanDirectoryNotExistsPlugin($scanner)
    {
        $pluginsInfos = $scanner->scanDirectory('plugin_sample3');
    }

    public function testScanDirectoryInvalidPluginFile()
    {
        $dir    = __DIR__.'/invalid_plugins';
        $reader = $this->getReaderMock($dir);

        $scanner = new PluginScanner($reader, $dir);

        $pluginsInfos = $scanner->scanDirectory();

        $this->assertEmpty($pluginsInfos);
    }

    /**
     * getReaderMock
     *
     * @return \Mockery\MockInterface
     */
    protected function getReaderMock($dir)
    {
        $reader = \Mockery::mock('Xpressengine\Plugin\MetaFileReader');
        $reader->shouldReceive('read')
            ->withArgs([$dir.'/plugin_sample'])
            ->andReturn(
                json_decode(
                '{
                      "name": "khongchi/plugin_sample",
                      "description": "khongchi 플러그인입니다.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
                      "support": {
                        "email": "sungbum00@gmail.com",
                        "issues": "http://myproject.com/issues",
                        "forum": "http://myproject.com/forum",
                        "wiki": "http://myproject.com/wiki",
                        "irc": "http://myproject.com/irc",
                        "source": "http://myproject.com/source/"
                      },
                      "authors": [
                        {
                          "name": "khongchi",
                          "email": "sungbum00@gmail.com",
                          "homepage": "https://xpressengine.io",
                          "role": "Developer"
                        }
                      ],
                      "license": "LGPL-2.0",
                      "type": "xpressengine-plugin",
                      "extra": {
                        "xpressengine": {
                          "components": {
                            "module|board": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board",
                              "name": "게시판",
                              "description": "게시판입니다."
                            },
                            "module|board|sortingType|default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\SortType\\\",
                              "name": "게시판 기본정렬타입",
                              "description": "게시판의 기본 정렬타입입니다."
                            },
                            "module|board|skin|default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
                              "name": "게시판 기본스킨",
                              "description": "게시판 기본스킨입니다."
                            },
                            "module|khongchi_forum": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum",
                              "name": "포럼",
                              "description": "포럼입니다."
                            },
                            "module|forum|skin|sketchbook": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "포럼용 스캐치북스킨",
                              "description": "포럼용 스캐치북스킨입니다."
                            },
                            "uiobject|phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "fieldType|phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "widget|content|skin|sketchbookDefault": {
                              "class": "Khongchi\\\PluginA\\\Widgets\\\Kboard",
                              "name": "kboard",
                              "description": "kboard 게시판 모듈"
                            }
                          }
                        }
                      },
                      "autoload": {
                        "psr-4": {
                          "Khongchi\\\Kboard\\\": "plugins/kboard"
                        },
                        "files": [
                          "core/src/Xpressengine/Interception/helpers.php"
                        ]
                      },
                      "repositories": [
                        {
                          "type": "composer",
                          "url": "http://packagist.test4.xehub.kr"
                        }
                      ],
                      "require": {
                        "xe3/ncenter": "*",
                        "vender/package": "x.x.x"
                      }
                    }', true
            )
            );

        $reader->shouldReceive('read')
            ->withArgs([$dir.'/plugin_sample2'])
            ->andReturn(
                json_decode(
                '{
                      "name": "khongchi/plugin_sample2",
                      "description": "khongchi 플러그인입니다.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
                      "support": {
                        "email": "sungbum00@gmail.com",
                        "issues": "http://myproject.com/issues",
                        "forum": "http://myproject.com/forum",
                        "wiki": "http://myproject.com/wiki",
                        "irc": "http://myproject.com/irc",
                        "source": "http://myproject.com/source/"
                      },
                      "authors": [
                        {
                          "name": "khongchi",
                          "email": "sungbum00@gmail.com",
                          "homepage": "https://xpressengine.io",
                          "role": "Developer"
                        }
                      ],
                      "license": "LGPL-2.0",
                      "type": "xpressengine-plugin",
                      "extra": {
                        "xpressengine": {
                          "components": {
                            "module|board": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board",
                              "name": "게시판",
                              "description": "게시판입니다."
                            },
                            "module|board|sortingType|default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\SortType\\\",
                              "name": "게시판 기본정렬타입",
                              "description": "게시판의 기본 정렬타입입니다."
                            },
                            "module|board|skin|default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
                              "name": "게시판 기본스킨",
                              "description": "게시판 기본스킨입니다."
                            },
                            "module|khongchi_forum": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum",
                              "name": "포럼",
                              "description": "포럼입니다."
                            },
                            "module|forum|skin|sketchbook": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "포럼용 스캐치북스킨",
                              "description": "포럼용 스캐치북스킨입니다."
                            },
                            "uiobject|phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "fieldType|phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "widget|content|skin|sketchbookDefault": {
                              "class": "Khongchi\\\PluginA\\\Widgets\\\Kboard",
                              "name": "kboard",
                              "description": "kboard 게시판 모듈"
                            }
                          }
                        }
                      },
                      "autoload": {
                        "psr-4": {
                          "Khongchi\\\Kboard\\\": "plugins/kboard"
                        },
                        "files": [
                          "core/src/Xpressengine/Interception/helpers.php"
                        ]
                      },
                      "repositories": [
                        {
                          "type": "composer",
                          "url": "http://packagist.test4.xehub.kr"
                        }
                      ],
                      "require": {
                        "xe3/ncenter": "*",
                        "vender/package": "x.x.x"
                      }
                    }', true
            )
            );


        $reader->shouldReceive('read')
            ->withArgs(['/home/DOMAINS/LOCALHOST/khongchi/xe3-core/core/tests/Plugin/invalid_plugins/plugin_sample2'])
            ->andReturn(
                json_decode(
                '{
                      "name": "khongchi/plugin_sample2",
                      "description": "khongchi 플러그인입니다.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
                      "support": {
                        "email": "sungbum00@gmail.com",
                        "issues": "http://myproject.com/issues",
                        "forum": "http://myproject.com/forum",
                        "wiki": "http://myproject.com/wiki",
                        "irc": "http://myproject.com/irc",
                        "source": "http://myproject.com/source/"
                      },
                      "authors": [
                        {
                          "name": "khongchi",
                          "email": "sungbum00@gmail.com",
                          "homepage": "https://xpressengine.io",
                          "role": "Developer"
                        }
                      ],
                      "license": "LGPL-2.0",
                      "type": "xpressengine-plugin",
                      "extra": {
                        "xpressengine": {
                          "components": {
                            "module|board": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board",
                              "name": "게시판",
                              "description": "게시판입니다."
                            },
                            "module|board|sortingType|default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\SortType\\\",
                              "name": "게시판 기본정렬타입",
                              "description": "게시판의 기본 정렬타입입니다."
                            },
                            "module|board|skin|default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
                              "name": "게시판 기본스킨",
                              "description": "게시판 기본스킨입니다."
                            },
                            "module|khongchi_forum": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum",
                              "name": "포럼",
                              "description": "포럼입니다."
                            },
                            "module|forum|skin|sketchbook": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "포럼용 스캐치북스킨",
                              "description": "포럼용 스캐치북스킨입니다."
                            },
                            "uiobject|phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "fieldType|phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "widget|content|skin|sketchbookDefault": {
                              "class": "Khongchi\\\PluginA\\\Widgets\\\Kboard",
                              "name": "kboard",
                              "description": "kboard 게시판 모듈"
                            }
                          }
                        }
                      },
                      "autoload": {
                        "psr-4": {
                          "Khongchi\\\Kboard\\\": "plugins/kboard"
                        },
                        "files": [
                          "core/src/Xpressengine/Interception/helpers.php"
                        ]
                      },
                      "repositories": [
                        {
                          "type": "composer",
                          "url": "http://packagist.test4.xehub.kr"
                        }
                      ],
                      "require": {
                        "xe3/ncenter": "*",
                        "vender/package": "x.x.x"
                      }
                    }', true
            )
            );

        return $reader;
    }
}
