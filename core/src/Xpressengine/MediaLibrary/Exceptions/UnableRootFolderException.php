<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class UnableRootFolderException extends HttpXpressengineException
{
    protected $message = 'xe::unableRootTargetMessage';
}
