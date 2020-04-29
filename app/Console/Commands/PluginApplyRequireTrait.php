<?php
/**
 * PluginApplyRequireTrait.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

        $writer->setUpdateMode(array_keys($installs + $updates));
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