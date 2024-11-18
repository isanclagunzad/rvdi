<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Database\PatchedBuilder;

class BaseModel extends Model
{
    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new PatchedBuilder(
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );
    }
}