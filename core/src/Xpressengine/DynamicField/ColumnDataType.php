<?php
/**
 * ColumnDataType
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamidField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\DynamicField;

/**
 * ColumnDataType
 *
 * * Type 에서 table 스키마 를 정의 하기위해 Column Entity 사용
 * * ColumnEntity class 에서 column 의 dataType 을 정의 할 때 사용 가능한 값 정의
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
