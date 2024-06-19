<?php

namespace Zidan\Menu\Models\Traits;

use Zidan\Menu\Database\Query\CacheableQueryBuilder;

trait QueryCacheTrait
{
    /**
     * Get a new query builder instance.
     * Overridden to return CacheableQueryBuilder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();
        return new CacheableQueryBuilder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor(),
            get_class($this)
        );
    }
}
