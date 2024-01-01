<?php

declare(strict_types=1);

namespace Bow\Http;

enum HttpVerbs : string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
    case OPTIONS = 'OPTIONS';
    case HEAD = 'HEAD';
    case CONNECT = 'CONNECT';
    case TRACE  = 'TRACE';
    case CLI = 'CLI';
    case ANY = 'ANY';
}
