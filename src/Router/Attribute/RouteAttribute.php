<?php

declare(strict_types=1);

namespace Bow\Router\Attribute;

use Attribute;

// generic for load routeon php attribut with spefic method
#[Attribute]

class RouteAttribute implements IRoute
{
    /**
     * RouteAttribute constructor.
     * @param string $method
     * @param string $path
     * @param string $name
     * @param array $with
     */
    public function __construct(
        private string $method,
        private string $path,
        private string $name = '',
        private array $with = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCallback(): mixed
    {
        return $this->cb;
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
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @inheritDoc
     */
    public function getMatch(): array
    {
        return $this->match;
    }

    /**
     * @inheritDoc
     */
    public function getWith(): array
    {
        return $this->with;
    }

}