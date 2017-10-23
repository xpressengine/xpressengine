<?php
/**
 * IpMatch.php
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

trait IpMatch
{
    /**
     * Checks if a given IP address matches the specified CIDR subnet/s
     *
     * @param string $ip    The IP address to check
     * @param mixed  $cidrs The IP subnet (string) or subnets (array) in CIDR notation
     * @param string $match optional If provided, will contain the first matched IP subnet
     * @return boolean TRUE if the IP matches a given subnet or FALSE if it does not
     *
     * @see https://gist.github.com/tott/7684443
     */
    protected function match($ip, $cidrs, &$match = null)
    {
        foreach ((array) $cidrs as $cidr) {
            if (strpos($cidr, '/') === false) {
                $cidr .= '/32';
            }
            list($subnet, $mask) = explode('/', $cidr);
            if (((ip2long($ip) & ($mask = ~ ((1 << (32 - $mask)) - 1))) == (ip2long($subnet) & $mask))) {
                $match = $cidr;
                return true;
            }
        }
        return false;
    }
}
