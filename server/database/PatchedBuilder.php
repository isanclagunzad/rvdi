<?php

namespace App\Database;

use Illuminate\Database\Query\Builder as BaseBuilder;

class PatchedBuilder extends BaseBuilder
{
    public function addWhereExistsQuery($query, $boolean = 'and', $not = false) 
    {
        $type = $not ? 'NotExists' : 'Exists';

        $this->wheres[] = compact('type', 'query', 'boolean');

        $this->addBinding($query->getBindings(), 'where');

        return $this;
    }
}