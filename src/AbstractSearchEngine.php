<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine;

use Vaened\CriteriaCore\Criteria;
use Vaened\CriteriaCore\Directives\{Expression, Filter, Scope};
use Vaened\CriteriaCore\Keyword\Order;

use function array_merge;

abstract class AbstractSearchEngine
{
    protected const DEFAULT_LIMIT = 15;

    protected int    $perPage   = self::DEFAULT_LIMIT;

    protected ?Order $order     = null;

    private array    $criterias = [];

    public abstract function list(int $page = 1, ?int $perPage = null): mixed;

    public abstract function paginate(int $page = 1, ?int $perPage = null): mixed;

    public function perPage(int $perPage): static
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function orderBy(Order $order): static
    {
        $this->order = $order;
        return $this;
    }

    protected function apply(Scope|Expression|Filter ...$criterias): void
    {
        $this->criterias = array_merge($this->criterias, $criterias);
    }

    protected function criteria(int $page = 1, ?int $perPage = null): Criteria
    {
        $perPage ??= $this->perPage;
        $offset  = ($page - 1) * $perPage;

        return new Criteria($this->criterias, $this->order, $perPage, $offset);
    }
}