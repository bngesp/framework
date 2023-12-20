<?php

declare(strict_types=1);

namespace Bow\Router\Attribute;

use Attribute;
// generic for load route with get method on php attribute 
#[Attribute]

class Post extends RouteAttribute
{
    /**
     * Post constructor.
     * @param string $path
     * @param string $name
     * @param array $with
     */
    public function __construct(
        private string $path,
        private string $name = '',
        private array $with = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getWith(): array
    {
        return $this->with;
    }
}