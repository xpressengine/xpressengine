<?php
/**
 * ColumnDataType
 *
 * PHP version 7
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

/**
 * ColumnDataType
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ColumnDataType
{
    const INTEGER = 'integer';
    const BIGINTEGER = 'bigInterge';
    const MEDIUMINTEGER = 'mediumInteger';
    const SMALLINTEGER = 'smallInteger';
    const TINYINTEGER = 'tinyInteger';

    const FLOAT = 'float';
    const DOUBLE = 'double';
    const DECIMAL = 'decimal';

    const BOOLEAN = 'boolean';
    const ENUM = 'enum';

    const BINARY = 'binary';

    const CHAR = 'char';
    const STRING = 'string';
    const TEXT = 'text';
    const MEDIUMTEXT = 'mediumText';
    const LONGTEXT = 'longText';

    const DATE = 'date';
    const DATETIME = 'dateTime';
    const TIMESTAMP = 'timestamp';
    const TIME = 'time';
}
