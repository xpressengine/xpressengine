<?php
/**
 * AgreementPart.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

use Xpressengine\User\Models\Term;

/**
 * Class AgreementPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class AgreementPart extends RegisterFormPart
{
    const ID = 'agreements';

    const NAME = 'xe::acceptTerms';

    const DESCRIPTION = 'xe::descAcceptTerms';

    private $enabled;

    /**
     * Indicates if the form part is implicit
     *
     * @var bool
     */
    protected static $implicit = true;

    /**
     * The view for the form part
     *
     * @var string
     */
    protected static $view = 'register.forms.agreements';

    /**
     * Get data for form part view
     *
     * @return array
     */
    protected function data()
    {
        return ['terms' => $this->getEnabled()];
    }

    /**
     * Get validation rules of the form part
     *
     * @return array
     */
    public function rules()
    {
        if (count($this->getEnabled()) > 0) {
            return ['agree' => 'accepted'];
        }

        return [];
    }

    /**
     * Get the terms of enabled
     *
     * @return Term[]
     */
    protected function getEnabled()
    {
        if (!$this->enabled) {
            $this->enabled = $this->service('xe.terms')->fetchEnabled();
        }

        return $this->enabled;
    }
}
