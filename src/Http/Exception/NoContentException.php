<?php

declare(strict_types=1);

namespace Bow\Http\Exception;

use Bow\Http\Exception\HttpException;
use Bow\Http\HttpCode;

class NoContentException extends HttpException
{
    /**
     * NoContentException constructor
     *
     * @param string $message
     * @param string $status
     */
    public function __construct(string $message, $status = 'NO_CONTENT')
    {
        parent::__construct($message, HttpCode::NO_CONTENT->code());

        $this->status = $status;
    }
}
