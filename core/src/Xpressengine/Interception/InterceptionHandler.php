<?php
/**
 * Class InterceptionHandler. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Interception;

use Xpressengine\Interception\Proxy\Loader\Loader;
use Xpressengine\Interception\Proxy\Pass\Pass;
use Xpressengine\Interception\Proxy\ProxyGenerator;

/**
 * 이 라이브러리는 AOP(aspect-oriented programming)을 구현한 라이브러리이며 이 클래스는 프로그램 내에서
 * AOP를 관리하는 역할을 한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class InterceptionHandler
{

    /**
     * @var AdvisorCollection advisor 저장소. 이 클래스를 통해 등록되는 모든 advisor는 AdvisorCollection에 저장된다.
     */
    protected $advisorCollection = null;

    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @var Pass
     */
    protected $passes;

    /**
     * @var ProxyGenerator
     */
    protected $proxyGenerator;

    /**
     * proxy가 생성된 클래스 목록
     * key는 target class name, value는 proxy class name을 저장한다.
     *
     * @var array
     */
    protected $proxyList = [];


    /**
     * constructor
     *
     * @param AdvisorCollection $advisorCollection advisor 저장소
     * @param ProxyGenerator    $generator         프록시 생성기
     */
    public function __construct(AdvisorCollection $advisorCollection, ProxyGenerator $generator)
    {
        $this->advisorCollection = $advisorCollection;
        $this->proxyGenerator = $generator;
    }

    /**
     * @return AdvisorCollection
     */
    public function getAdvisorCollection()
    {
        return $this->advisorCollection;
    }

    /**
     * advisor의 구성정보를 파라메터로 입력받아 advisorCollection에 추가한다.
     * 이 함수를 직접 호출하는 대신 intercept() 헬퍼함수를 사용하십시오.
     *
     *
     * @param array|string $pointCut    advisor의 point cut을 지정한다. point cut은 [타겟클래스명]@[메소드명] 형태의 string 또는,
     *                                  string array 형식을 가진다.
     *                                  예: 'Document@insertDocument' 또는
     *                                  ['Document@insertDocument', 'Document@updateDocument']
     * @param array|string $advisorInfo advisor의 이름을 지정한다. 필요한 경우 before, after advisor의 이름을 지정하여 우선순위를 지정할
     *                                  수 있다.
     *                                  예: 'spamfilter.insertDocument' - advisor 이름으로 spamfilter.insertDocument를 지정
     *                                  ['spamfilter.insertDocument' => 'mailing.insertDocument'] - before advisor로
     *                                  mailing.insertDocument를 지정, mailing이 먼저 실행된 후, spamfilter가 실행된다.
     * @param \Closure     $advice      advisor가 작동할 때 실행될 코드를 지정한다. Closure 형식으로 지정한다.
     *                                  예:
     *                                  function($target, $arg1, $arg2, $arg3) {
     *                                  $target($arg1, $arg2, $arg3);
     *                                  }
     *
     * @return Advisor 추가된 advisor
     */
    public function addAdvisor($pointCut, $advisorInfo, $advice)
    {
        $info = $this->resolveAdvisorInfo($advisorInfo);

        $advisor = new Advisor($info['name'], $pointCut, $advice);

        $this->advisorCollection->put($advisor, ['before' => $info['before'], 'after' => $info['after']]);

        return $advisor;
    }

    /**
     * addAdvisor 메소드를 통해 입력받은 advisorInfo에서 정보를 추출한다.
     * 추출되는 정보는 advisor의 이름, advisor의 before, after 관계의 다른 advisor 목록이다.
     *
     * @param array $advisorInfo 정보를 추출할 배열
     *
     * @return array 추출된 정보
     */
    protected function resolveAdvisorInfo($advisorInfo)
    {
        $before = null;
        $after = null;

        if (is_array($advisorInfo)) {
            $advisorName = array_keys($advisorInfo)[0];
            $before = $this->resolveBeforeAdvisor($advisorInfo[$advisorName]);
            $after = $this->resolveAfterAdvisor($advisorInfo[$advisorName]);
        } else {
            $advisorName = $advisorInfo;
        }

        $resolvedInfo = [];
        $resolvedInfo['name'] = $advisorName;

        $resolvedInfo['before'] = $before;
        $resolvedInfo['after'] = $after;

        return $resolvedInfo;
    }

    /**
     * advisorInfo에서 before advisor name을 추출한다.
     *
     * @param string|array $priority advisorInfo의 priority 영역
     *
     * @return string|array|null before advisor name 목록
     */
    private function resolveBeforeAdvisor($priority)
    {
        /*
         * $priority = ['before'=>'a', 'after'=>'b']
         * $priority = ['after'=>'b']
         * $priority = ['before'=>['a'], 'after'=>'b']
         * $priority = ['before'=>'a', 'after'=>'b']
         * */
        if (is_array($priority)) {
            if (isset($priority['before'])) {
                return $priority['before'];
            } elseif (isset($priority['after'])) {
                return null;
            }
        }

        // 암묵적인 before 선언시
        return $priority;
    }

    /**
     * advisorInfo에서 after advisor name을 추출한다.
     *
     * @param string|array $priority advisorInfo의 priority 영역
     *
     * @return string|array|null after advisor name 목록
     */
    private function resolveAfterAdvisor($priority)
    {
        if (is_array($priority) && isset($priority['after'])) {
            return $priority['after'];
        }
        return null;
    }

    /**
     * 타겟 클래스의 프록시 클래스를 생성하여 로드하고, 생성된 프록시 클래스 이름을 반환한다.
     * 만약 어떤 클래스에 interception을 적용하고 싶을 때 이 메소드를 사용하면 된다.
     *
     * ```
     * $targetClassName = 'My\Namespace\PostManager';
     * $proxyClass = XeInterception::proxy($targetClass, 'Post');
     *
     * $postManager = new $proxyClass();
     * ```
     * 두번째 파라메터를 사용하여 타겟클래스의 alias 이름을 등록할 수 있다. alias 이름을 지정하면,
     * 타겟 클래스에 interception을 등록할 때, alias 이름을 사용할 수 있다.
     *
     * ```
     * // Post alias를 사용
     * intercept('Post@insert', 'spam_filter', function(){...});
     * ```
     *
     * @param string      $targetClass 타겟 클래스
     * @param string|null $alias       타겟 클래스의 별칭
     *
     * @return string
     */
    public function proxy($targetClass, $alias = null)
    {
        $targetClass = trim($targetClass);

        if ($alias !== null) {
            $this->advisorCollection->setAlias($alias, $targetClass);
        }

        $proxyClass = $this->proxyGenerator->generate($targetClass);

        $this->proxyList[$targetClass] = $proxyClass;

        return $proxyClass;
    }

    /**
     * 생성된 proxy class 리스트를 반환한다.
     *
     * @return array
     */
    public function getProxyList()
    {
        return $this->proxyList;
    }

    /**
     * 기생성된 Proxy 파일을 모두 삭제한다.
     *
     * @return void
     */
    public function clearProxies()
    {
        $this->proxyGenerator->clear();
    }
}
