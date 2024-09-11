<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Concerns;

use Vaened\CriteriaCore\Directives\Expression;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Directives\Scope;
use Vaened\SearchEngine\AbstractSearchEngine;
use Vaened\SearchEngine\FlagBag;
use Vaened\SearchEngine\Flagger;

/**
 * Facilitates the search by flags.
 *
 * @mixin AbstractSearchEngine
 */
trait Flagable
{
    abstract protected function filterer(): Flagger;

    public function filter(FlagBag $flags): self
    {
        $this->filterer()
             ->only($flags)
             ->each(
                 fn(Scope|Expression|Filter $criteria) => $this->apply($criteria)
             );

        return $this;
    }
}
