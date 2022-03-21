<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class ModelTestCase extends TestCase
{
    protected function runConfigurationAssertions(Model $model, $assertions)
    {
        $assertions = array_merge([
            'fillable' => [],
            'hidden' => [],
            'guarded' => ['*'],
            'visible' => [],
            'table' => null,
            'primaryKey' => 'id',
            'casts' => ['id' => 'int'],
            'dates' => ['created_at', 'updated_at'],
            'collectionClass' => Collection::class,
            'connection' => null,
        ], $assertions);

        extract($assertions);
        $this->assertEquals($assertions['fillable'], $model->getFillable());
        $this->assertEquals($assertions['guarded'], $model->getGuarded());
        $this->assertEquals($assertions['hidden'], $model->getHidden());
        $this->assertEquals($assertions['visible'], $model->getVisible());
        $this->assertEquals($assertions['casts'], $model->getCasts());
        $this->assertEquals($assertions['dates'], $model->getDates());
        $this->assertEquals($assertions['primaryKey'], $model->getKeyName());
        $c = $model->newCollection();
        $this->assertEquals($assertions['collectionClass'], get_class($c));
        $this->assertInstanceOf(Collection::class, $c);
        if ($assertions['connection'] !== null) {
            $this->assertEquals($assertions['connection'], $model->getConnectionName());
        }
        if ($assertions['table'] !== null) {
            $this->assertEquals($assertions['table'], $model->getTable());
        }
    }

    /**
     * @param HasMany $relation
     * @param Model $model
     * @param Model $related
     * @param string $key
     * @param string $parent
     * @param \Closure $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKeyName()`: any `HasOneOrMany` or `BelongsTo` relation,
     * but key type differs (see documentaiton).
     * - `getQualifiedParentKeyName()`: in case of `HasOneOrMany` relation,
     * there is no `getLocalKey()` method, so this one should be asserted.
     */
    protected function assertHasManyRelation(
        $relation,
        Model $model,
        Model $related,
        $key = null,
        $parent = null,
        \Closure $queryCheck = null
    ) {
        $this->assertInstanceOf(HasMany::class, $relation);

        if (!is_null($queryCheck)) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        if (is_null($key)) {
            $key = $model->getForeignKey();
        }

        $this->assertEquals($key, $relation->getForeignKeyName());

        if (is_null($parent)) {
            $parent = $model->getKeyName();
        }

        $this->assertEquals($model->getTable().'.'.$parent, $relation->getQualifiedParentKeyName());
    }

    /**
     * @param BelongsTo $relation
     * @param Model $model
     * @param Model $related
     * @param string $key
     * @param string $owner
     * @param \Closure $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKeyName()`: any `HasOneOrMany` or `BelongsTo` relation,
     * but key type differs (see documentaiton).
     * - `getOwnerKeyName()`: `BelongsTo` relation and its extendings.
     */
    protected function assertBelongsToRelation(
        $relation,
        Model $model,
        Model $related,
        $key,
        $owner = null,
        \Closure $queryCheck = null
    ) {
        $this->assertInstanceOf(BelongsTo::class, $relation);

        if (!is_null($queryCheck)) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        $this->assertEquals($key, $relation->getForeignKeyName());

        if (is_null($owner)) {
            $owner = $related->getKeyName();
        }

        $this->assertEquals($owner, $relation->getOwnerKeyName());
    }

    /**
     * @param BelongsToMany $relation
     * @param Model $model
     * @param Model $related
     * @param string $key
     * @param string $relater
     * @param \Closure $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getQualifiedForeignPivotKeyName()`: BelongsToMany relation,
     * get the fully qualified foreign key for the relation.
     * - `getQualifiedRelatedPivotKeyName()`: `BelongsTo` relation and its extendings.
     */
    protected function assertBelongsToManyRelation(
        $relation,
        Model $model,
        Model $related,
        $key,
        $relater = null,
        \Closure $queryCheck = null
    ) {
        $this->assertInstanceOf(BelongsToMany::class, $relation);

        if (!is_null($queryCheck)) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }

        $this->assertEquals($key, $relation->getQualifiedForeignPivotKeyName());

        if (is_null($relater)) {
            $relater = $related->getKeyName();
        }

        $this->assertEquals($relater, $relation->getQualifiedRelatedPivotKeyName());
    }
}
