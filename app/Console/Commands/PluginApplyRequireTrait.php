<?php
/**
 * PluginApplyRequireTrait.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Xpressengine\Foundation\Operations\PluginOperation;
use Xpressengine\Plugin\Composer\ComposerFileWriter;

/**
 * Trait PluginApplyRequireTrait
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
trait PluginApplyRequireTrait
{
    /**
     * plugin composer 파일에 등록된 플러그인 제어정보를 require에 적용한다.
     *
     * @param PluginOperation $operation plugin operation
     * @return void
     */
    protected function applyRequire(PluginOperation $operation)
    {
        $writer = $this->getWriter();

        $installs = $operation->getInstall();
        foreach ($installs as $name => $version) {
            $writer->addRequire($name, $version);
        }
        $updates = $operation->getUpdate();
        foreach ($updates as $name => $version) {
            $writer->addRequire($name, $version);
        }
        $uninstalls = $operation->getUninstall();
        foreach ($uninstalls as $name) {
            $writer->removeRequire($name);
        }

        $writer->setUpdateMode(array_merge(array_keys($installs), array_keys($updates)));
        $writer->write();
    }

    /**
     * 플러그인 정보를 변경 이전으로 복구.
     *
     * @return void
     */
    protected function rollbackRequire()
    {
        $this->getWriter()->rollback();
    }

    /**
     * Return ComposerFileWriter instance.
     *
     * @return ComposerFileWriter
     */
    protected function getWriter()
    {
        return app(ComposerFileWriter::class);
    }
}