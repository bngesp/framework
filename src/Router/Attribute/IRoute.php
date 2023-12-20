<?php

declare(strict_types=1);
namespace Bow\Router\Attribute;
 // generic for load route on php attribute
interface IRoute
{
    /**
     * The callback has launched if the url of the query has matched.
     *
     * @var callable
     */
    public function getCallback(): mixed;

    /**
     * The road on the road set by the user
     *
     * @var string
     */
    public function getPath(): string;

    /**
     * The route name
     *
     * @var string
     */
    public function getName(): string;

    /**
     * key
     *
     * @var array
     */
    public function getKeys(): array;

    /**
     * The route parameter
     *
     * @var array
     */
    public function getParams(): array;

    /**
     * List of parameters that we match
     *
     * @var array
     */
    public function getMatch(): array;

    /**
     * Additional URL validation rule
     *
     * @var array
     */
    public function getWith(): array;
}