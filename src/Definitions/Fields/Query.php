<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators\Fields;

use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaCore\Statement;
use Vaened\SearchEngine\Evaluators\Field;
use Vaened\SearchEngine\Evaluators\Pattern;
use Vaened\SearchEngine\Evaluators\ValueMultiplier;

final class Query implements Field
{
    public function __construct(
        private readonly string         $target,
        private readonly FilterOperator $operator,
        private readonly Pattern        $pattern,
    )
    {
    }

    public static function must(string $target, FilterOperator $operator, Pattern $pattern): self
    {
        return new self($target, $operator, $pattern);
    }

    public function match(string $value): bool
    {
        if (ValueMultiplier::canApplyFor($this->operator, $value)) {
            return ValueMultiplier::evaluate($this->pattern, $value);
        }

        return $this->pattern->evaluate($value);
    }

    public function resolve(string $value): Filter
    {
        return Statement::that(
            $this->target,
            $this->operator(),
            $this->format($value)
        );
    }

    private function operator(): FilterOperator
    {
        if (ValueMultiplier::isSupportedOperator($this->operator)) {
            return ValueMultiplier::transform($this->operator);
        }

        return $this->operator;
    }

    private function format(string $value): mixed
    {
        if (ValueMultiplier::canApplyFor($this->operator, $value)) {
            return ValueMultiplier::format($this->pattern, $value);
        }

        return $this->pattern->format($value);
    }
}
