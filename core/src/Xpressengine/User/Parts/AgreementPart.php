<?php
/**
 * AgreementPart.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

use Xpressengine\Http\Request;
use Xpressengine\User\Models\Term;
use Xpressengine\User\UserRegisterHandler;

/**
 * Class AgreementPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AgreementPart extends RegisterFormPart
{
    const ID = 'agreements';

    const NAME = 'xe::acceptTerms';

    const DESCRIPTION = 'xe::descAcceptTerms';

    private $enabled;

    /** @var bool $isUsePart 회원가입 설정에 따른 사용 여부 확인 */
    private $isUsePart;

    /**
     * Indicates if the form part is implicit
     *
     * @var bool
     */
    protected static $implicit = true;

    /**
     * AgreementPart constructor.
     *
     * @param Request $request request
     */
    public function __construct(Request $request)
    {
        $this->isUsePart = app('xe.config')->getVal(
            'user.register.term_agree_type',
            UserRegisterHandler::TERM_AGREE_WITH
        ) === UserRegisterHandler::TERM_AGREE_WITH;

        parent::__construct($request);
    }

    /**
     * The view for the form part
     *
     * @var string
     */
    protected static $view = 'register.forms.agreements';

    /**
     * @return \Illuminate\Support\HtmlString|string
     */
    public function render()
    {
        if ($this->isUsePart === false) {
            return '';
        }

        return parent::render();
    }

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
        if ($this->isUsePart === true && count($this->getEnabled()) > 0) {
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
