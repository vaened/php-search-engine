<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators\Aspects\Regex;

use Vaened\SearchEngine\Evaluators\StringFiller;

final class AutoFillNumber extends Number
{
    public function __construct(private readonly int $maxLength, int $minLength = 1)
    {
        parent::__construct($maxLength, $minLength);
    }

    public function format(string $value): string
    {
        return StringFiller::from('0', $this->maxLength)->fill($value);
    }
}
