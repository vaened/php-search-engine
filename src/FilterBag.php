<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine;

use BackedEnum;
use Vaened\CriteriaCore\Directives\{Expression, Filter, Scope};
use Vaened\Support\Types\ArrayList;

final class FilterBag
{
    private array $filters = [];

    public static function open(): self
    {
        return new self();
    }

    /**
     * Registers the possible filters that can be applied to the search.
     *
     * @param BackedEnum $enum
     * @param callable(mixed): <Filter|Expression|Scope> $action
     *
     * @return FilterBag
     */
    public function register(BackedEnum $enum, callable $action): self
    {
        $this->filters[$enum->value] = $action;
        return $this;
    }

    public function only(FlagBag $flags): ArrayList
    {
        return $flags->map(fn(BackedEnum $flag) => $this->get($flag));
    }

    public function has(BackedEnum $enum): bool
    {
        return isset($this->filters[$enum->value]);
    }

    public function get(BackedEnum $enum): ?callable
    {
        return $this->filters[$enum->value] ?? null;
    }

    public function filters(): array
    {
        return $this->filters;
    }
}
