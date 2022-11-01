<?php

declare(strict_types=1);

namespace Bow\Database\Barry\Relations;

use Bow\Database\Barry\Relation;
use Bow\Database\Barry\Model;

class BelongsToMany extends Relation
{
    /**
     * The foreign key of the parent model.
     *
     * @var string
     */
    protected $foreign_key;

    /**
     * The associated key on the parent model.
     *
     * @var string
     */
    protected $local_key;

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
        $this->local_key = $local_key;
        $this->foreign_key = $foreign_key;

        parent::__construct($related, $parent);
    }

    /**
     * Get the results of the relationship.
     *
     * @return Collection
     */
    public function getResults(): Collection
    {
        // TODO: Cache the result
        return $this->query->get();
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        if (static::$has_constraints) {
            // Todo
        }
    }
}
