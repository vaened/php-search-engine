<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators\Aspects;

use Vaened\SearchEngine\Evaluators\Pattern;

use function preg_match;

abstract class Regex implements Pattern
{
    abstract protected function pattern(): string;

    public function evaluate(string $value): bool
    {
        return preg_match($this->pattern(), $value) > 0;
    }
}
