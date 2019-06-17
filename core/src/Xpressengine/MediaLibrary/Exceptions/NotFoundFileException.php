<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class NotFoundFileException extends HttpXpressengineException
{
    protected $message = 'xe::fileNotFoundMessage';
}
