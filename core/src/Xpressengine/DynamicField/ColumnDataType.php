<?php
/**
 * Column Data Type class
 *
 * PHP version 5
 *
 * @category    DyanmicField
 * @package     Xpressengine\DynamidField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\DynamicField;

/**
 * FieldType에서 table 스키마 를 정의 하기위해 Column Entity를 사용합니다.
 * ColumnEntity class에서 column의 dataType을 정의 할 때 이 사용 가능한 값을 정의합니다.
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
