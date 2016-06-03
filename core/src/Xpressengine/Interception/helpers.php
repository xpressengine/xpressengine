<?php
/**
 * intercept function. This file is part of the Xpressengine package.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (function_exists('intercept') === false) {
    /**
     * 이 함수는 Xpressengine에서 aop를 사용하기 위해 구현된 함수이다. 이 함수를 사용하여, Proxy가 지정된 특정 클래스의 메소드가 실행될 때,
     * 항상 먼저 실행될 Closure(advice)를 지정할 수 있다.
     * ```
     *  // Document클래스의 insertDocument 메소드가 실행될 때 실행될 Closure 등록
     *  intercept(
     *      'Document@insertDocument',
     *      'spamfilter',
     *      function ($target, $title, $content) {
     *          if($this->checkSpam($content)) {
     *              return $target($title, $content);
     *          } else {
     *              throw new \Exception();
     *          }
     *      }
     *  );
     *
     * ```
     *
     * 또한 다른 advice와의 실행순서를 지정할 수도 있다.
     *
     * ```
     *  // mailsend가 실행된 후, logging이 실행되기 전에 이 advice(spamfilter)를 실행하도록 지정
     *  intercept(
     *      'Document@insertDocument',
     *      ['spamfilter' => ['before'=>'mailsend','after'=>'logging']],
     *      function ($target, $title, $content) {
     *          if($this->checkSpam($content)) {
     *              return $target($title, $content);
     *          } else {
     *              throw new \Exception();
     *          }
     *      }
     *  );
     * ```
     *
     * @param string       $pointCut advice가 실행되기를 바라는 대상 클래스와 메소드, {CLASS명}@{METHOD명}의 형식이어야 한다.
     * @param string|array $name     advisor의 이름 및 우선순위 지정을 위한 array
     * @param Closure      $advice   실행될 Closure
     *
     * @return void
     */
    function intercept($pointCut, $name, Closure $advice)
    {
        \XeInterception::addAdvisor($pointCut, $name, $advice);
    }
}
