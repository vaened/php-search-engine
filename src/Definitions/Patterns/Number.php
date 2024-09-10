<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators\Aspects\Regex;

use Vaened\SearchEngine\Evaluators\Aspects\Regex;

use function sprintf;

class Number extends Regex
{
    public function __construct(
        private readonly int $maxLength = 99,
        private readonly int $minLength = 1
    )
    {
    }

    public function format(string $value): string
    {
        return $value;
    }

    protected function pattern(): string
    {
        return sprintf('/^[0-9]{%s,%s}$/', $this->minLength, $this->maxLength);
    }
}
