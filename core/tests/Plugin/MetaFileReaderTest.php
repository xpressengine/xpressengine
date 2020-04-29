<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin;

use Xpressengine\Plugin\MetaFileReader;

class MetaFileReaderTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testRead()
    {
        $reader = new MetaFileReaderStub('composer.json');

        $data = $reader->read('anything.file');

        $this->assertEquals('xe/plugin_a', $data['name']);
        $this->assertEquals('xe', $data['authors'][0]['name']);
    }
}

class MetaFileReaderStub extends MetaFileReader
{

    protected function getFileContents($fileName)
    {
        return '{
  "name": "xe/plugin_a",
  "description": "xe 플러그인입니다.",
  "keywords": [
    "xpressengine",
    "board"
  ],
  "support": {
    "email": "developers@xpressengine.com",
    "issues": "http://myproject.com/issues",
    "forum": "http://myproject.com/forum",
    "wiki": "http://myproject.com/wiki",
    "irc": "http://myproject.com/irc",
    "source": "http://myproject.com/source/"
  },
  "authors": [
    {
      "name": "xe",
      "email": "developers@xpressengine.com",
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
          "class": "XE\\\PluginA\\\Modules\\\Board",
          "name": "게시판",
          "description": "게시판입니다."
        },
        "module|board|sortingType|default": {
          "class": "XE\\\PluginA\\\Modules\\\Board\\\SortType\\\",
          "name": "게시판 기본정렬타입",
          "description": "게시판의 기본 정렬타입입니다."
        },
        "module|board|skin|default": {
          "class": "XE\\\PluginA\\\Modules\\\Board\\\Skins\\\Default",
          "name": "게시판 기본스킨",
          "description": "게시판 기본스킨입니다."
        },
        "module|xe_forum": {
          "class": "XE\\\PluginA\\\Modules\\\Forum",
          "name": "포럼",
          "description": "포럼입니다."
        },
        "module|forum|skin|sketchbook": {
          "class": "XE\\\PluginA\\\Modules\\\Forum\\\Skins\\\Sketchbook",
          "name": "포럼용 스캐치북스킨",
          "description": "포럼용 스캐치북스킨입니다."
        },
        "uiobject|phone": {
          "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
          "name": "전화번호 UI오브젝트",
          "description": "게시판정보 UI오브젝트입니다."
        },
        "fieldType|phone": {
          "class": "XE\\\PluginA\\\UIObjects\\\BoardInfo",
          "name": "전화번호 UI오브젝트",
          "description": "게시판정보 UI오브젝트입니다."
        },
        "widget|content|skin|sketchbookDefault": {
          "class": "XE\\\PluginA\\\Widgets\\\Kboard",
          "name": "kboard",
          "description": "kboard 게시판 모듈"
        }
      }
    }
  },
  "autoload": {
    "psr-4": {
      "XE\\\Kboard\\\": "plugins/kboard"
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
}';
    }
}
