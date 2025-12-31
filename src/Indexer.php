<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine;

use BackedEnum;
use Vaened\CriteriaCore\Directives\{Expression, Filter, Predicate, Scope};

use function Lambdish\Phunctional\apply;

abstract class Indexer
{
    abstract public function indexes(): FilterBag;

    public function search(BackedEnum $index, string $queryString): null|Predicate|Scope|Expression|Filter
    {
        $criteria = $this->indexes()->get($index);

        if (null === $criteria) {
            return null;
        }

        return apply($criteria, [$queryString]);
    }
}
