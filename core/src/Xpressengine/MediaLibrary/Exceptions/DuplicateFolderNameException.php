<?php

namespace Xpressengine\MediaLibrary\Exceptions;

use Xpressengine\Support\Exceptions\HttpXpressengineException;

class DuplicateFolderNameException extends HttpXpressengineException
{
    protected $message = 'xe::folderNameDuplicateMessage';
}
