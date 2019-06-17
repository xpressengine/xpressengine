<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class NotExistRootFolderException extends HttpXpressengineException
{
    protected $message = 'xe::rootFolderNotExistMessage';
}
