<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class NotFoundFolderException extends HttpXpressengineException
{
    protected $message = 'xe::folderNotFoundMessage';
}
