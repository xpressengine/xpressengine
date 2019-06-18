<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class DuplicateFileTitleException extends HttpXpressengineException
{
    protected $message = 'xe::fileNameDuplicateMessage';
}
