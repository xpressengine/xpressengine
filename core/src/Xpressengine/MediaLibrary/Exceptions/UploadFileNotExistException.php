<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class UploadFileNotExistException extends HttpXpressengineException
{
    protected $message = 'xe::notExistUploadFileMessage';
}
