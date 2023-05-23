<?php

declare(strict_types=1);

namespace Bow\Database\Barry\Relations;

use Bow\Cache\Cache;
use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relation;

class HasOne extends Relation
{
    /**
     * The foreign key of the parent model.
     *
     * @var string
     */
    protected string $foreign_key;

    /**
     * The associated key on the parent model.
     *
     * @var string
     */
    protected string $local_key;

    /**
     * Create a new belongs to relationship instance.
     *
     * @param Model $related
     * @param Model $parent
     * @param string  $foreign_key
     * @param string  $local_key
     */
    public function __construct(Model $related, Model $parent, string $foreign_key, string $local_key)
    {
        parent::__construct($related, $parent);

        $this->local_key = $local_key;
        $this->foreign_key = $foreign_key;

        $this->query = $this->query->where($this->foreign_key, $this->parent->$local_key);
    }

    /**
     * Get the results of the relationship.
     *
     * @return Model
     */
    public function getResults(): ?Model
    {
        $key = $this->query->getTable() . "_" . $this->local_key;
        $cache = Cache::cache('file')->get($key);

        if (!is_null($cache)) {
            $related = new $this->related();
            $related->setAttributes($cache);
            return $related;
        }

        $result = $this->query->first();

        if (!is_null($result)) {
            Cache::cache('file')->add($key, $result->toArray(), 500);
        }

        return $result;
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints(): void
    {
        if (static::$has_constraints) {
            // Todo
        }
    }
}
