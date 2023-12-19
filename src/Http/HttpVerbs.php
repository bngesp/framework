<?php

declare(strict_types=1);

namespace Bow\Http;

enum HttpVerbs 
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
    case OPTIONS;
    case HEAD;
    case CONNECT;
    case TRACE;
    case CLI;
    case ANY;
}
