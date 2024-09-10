<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine;

use Vaened\CriteriaCore\Directives\Expression;
use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Directives\Scope;
use Vaened\SearchEngine\Evaluators\Field;

final class QueryStringMatcher
{
    private readonly array $fields;

    public function __construct(Field ...$fields)
    {
        $this->fields = $fields;
    }

    public static function of(Field ...$fields): self
    {
        return new self(...$fields);
    }

    public function resolve(string $value): null|Scope|Expression|Filter
    {
        return $this->firstMatchOf($value)?->resolve($value);
    }

    private function firstMatchOf(string $value): ?Field
    {
        foreach ($this->fields as $field) {
            if ($field->match($value)) {
                return $field;
            }
        }

        return null;
    }
}
