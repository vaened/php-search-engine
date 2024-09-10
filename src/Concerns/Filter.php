<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Concerns;

use BackedEnum;

use function Lambdish\Phunctional\reduce;

/**
 * Provides functionality to list enums and convert them to a name -> label list.
 *
 * @mixin BackedEnum
 */
trait Filter
{
    abstract public function label(): string;

    public function pluck(): array
    {
        return reduce(function (array $dictionary, self $filter): array {
            $dictionary[$filter->value] = $filter->label();
            return $dictionary;
        }, static::cases(), []);
    }
}
