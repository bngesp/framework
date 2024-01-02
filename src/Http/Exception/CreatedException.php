<?php

declare(strict_types=1);

namespace Bow\Http\Exception;

use Bow\Http\Exception\HttpException;
use Bow\Http\HttpCode;

class CreatedException extends HttpException
{
    /**
     * CreatedException constructor
     *
     * @param string $message
     * @param string $status
     */
    public function __construct(string $message, $status = 'CONTENT_CREATED')
    {
        parent::__construct($message, HttpCode::CREATED->code());

        $this->status = $status;
    }
}
