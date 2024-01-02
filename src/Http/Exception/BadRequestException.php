<?php

declare(strict_types=1);

namespace Bow\Http\Exception;

use Bow\Http\Exception\HttpException;
use Bow\Http\HttpCode;

class BadRequestException extends HttpException
{
    /**
     * BadRequestException constructor
     *
     * @param string $message
     * @param string $status
     */
    public function __construct(string $message, $status = 'BAD_REQUEST')
    {
        parent::__construct($message, HttpCode::BAD_REQUEST->code());

        $this->status = $status;
    }
}
