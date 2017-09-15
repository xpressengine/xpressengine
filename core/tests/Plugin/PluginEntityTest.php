<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Mockery;
use Mockery\MockInterface;
use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginEntity;

class PluginEntityTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $entity = new PluginEntity(
            'plugin_sample',
            __DIR__.'/plugins/plugin_sample/plugin.php',
            '\Xpressengine\Tests\Plugin\Sample\PluginSample',
            $this->getMetaData()
        );


        $this->assertInstanceOf('\Xpressengine\Plugin\PluginEntity', $entity);

        return $entity;
    }


    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetId($entity)
    {
        $this->assertEquals('plugin_sample', $entity->getId());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetClass($entity)
    {
        $this->assertEquals('\Xpressengine\Tests\Plugin\Sample\PluginSample', $entity->getClass());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetObejct($entity)
    {
        $plugin = $entity->getObject();
        $this->assertInstanceOf('\Xpressengine\Tests\Plugin\Sample\PluginSample', $plugin);

        Mockery::mock(
            'alias:Component',
            '\Xpressengine\Plugin\ComponentInterface',
            [
                'setId' => null,
                'setComponentInfo' => null,
            ]
        );

        return $plugin;
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testCheckUpdate($entity)
    {
        $entity->setInstalledVersion('2.0.0');
        $this->assertFalse($entity->checkUpdate());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testToArray($entity)
    {
        $this->assertEquals('plugin_sample', $entity->toArray()['id']);
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetMetaData($entity)
    {
        $meta = $entity->getMetaData();
        $this->assertEquals('2.0.1', $meta['version']);

        $version = $entity->getMetaData('version');
        $this->assertEquals('2.0.1', $version);
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetComponentList($entity)
    {
        $components = $entity->getComponentList();

        $this->assertEquals('게시판', $components['module/board']['name']);

        $modules = $entity->getComponentList('module');

        $this->assertCount(2, $modules);
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetDependencies($entity)
    {
        $collection = Mockery::mock('\Xpressengine\Plugin\PluginCollection');
        $collection->shouldReceive('get')->withArgs(['ncenter'])->once()->andReturnNull();

        $entity->setCollection($collection);
        $this->assertEmpty($entity->getDependencies());
    }

    /**
     * @depends testConstruct
     *
     * @param \Xpressengine\Plugin\PluginEntity $entity
     */
    public function testGetters($entity)
    {
        $this->assertEquals('title',$entity->getTitle());
        $this->assertEquals(__DIR__.'/plugins/plugin_sample',$entity->getPath());
        $this->assertEquals('khongchi plugin.', $entity->getDescription());
        $this->assertCount(6, $entity->getSupport());
        $this->assertEquals('khongchi/plugin_sample', $entity->getName());
        $this->assertEquals(['xpressengine', 'board'], $entity->getKeywords());
        $this->assertEquals('khongchi',$entity->getAuthors()[0]['name']);
        $this->assertEquals('LGPL-2.0',$entity->getLicense());
    }

    private function getMetaData()
    {
        return json_decode(
            '{
                      "name": "khongchi/plugin_sample",
                      "description": "khongchi plugin.",
                      "keywords": [
                        "xpressengine",
                        "board"
                      ],
                      "version": "2.0.1",
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
                          "title": "title",
                          "component": {
                            "module/board": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board",
                              "name": "게시판",
                              "description": "게시판입니다."
                            },
                            "module/board/sortingType/default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\SortType",
                              "name": "게시판 기본정렬타입",
                              "description": "게시판의 기본 정렬타입입니다."
                            },
                            "module/board/skin/default": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Board\\\Skins\\\Base",
                              "name": "게시판 기본스킨",
                              "description": "게시판 기본스킨입니다."
                            },
                            "module/khongchi_forum": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum",
                              "name": "포럼",
                              "description": "포럼입니다."
                            },
                            "module/forum/skin/sketchbook": {
                              "class": "Khongchi\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
                              "name": "포럼용 스캐치북스킨",
                              "description": "포럼용 스캐치북스킨입니다."
                            },
                            "uiobject/phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "fieldType/phone": {
                              "class": "Khongchi\\\PluginA\\\UIObjects\\\BoardInfo",
                              "name": "전화번호 UI오브젝트",
                              "description": "게시판정보 UI오브젝트입니다."
                            },
                            "widget/content/skin/sketchbookBase": {
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
                        "xe3/ncenter": "*"
                      }
                    }',
            true
        );
    }

}

