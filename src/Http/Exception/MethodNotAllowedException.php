<?php

declare(strict_types=1);

namespace Bow\Http\Exception;

use Bow\Http\Exception\HttpException;
use Bow\Http\HttpCode;

class MethodNotAllowedException extends HttpException
{
    /**
     * MethodNotAllowedException constructor
     *
     * @param string $message
     * @param string $status
     */
    public function __construct(string $message, $status = 'METHOD_NOT_ALLOWED')
    {
        parent::__construct($message, HttpCode::METHOD_NOT_ALLOWED->code());

        $this->status = $status;
    }
}
