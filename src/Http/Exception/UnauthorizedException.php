<?php

declare(strict_types=1);

namespace Bow\Http\Exception;

use Bow\Http\Exception\HttpException;
use Bow\Http\HttpCode;

class UnauthorizedException extends HttpException
{
    /**
     * UnauthorizedException constructor
     *
     * @param string $message
     * @param string $status
     */
    public function __construct(string $message, $status = 'UNAUTHORIZED')
    {
        parent::__construct($message, HttpCode::UNAUTHORIZED->code());

        $this->status = $status;
    }
}
