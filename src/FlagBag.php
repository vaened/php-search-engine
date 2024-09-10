<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine;

use BackedEnum;
use Vaened\Support\Types\SecureList;

final class FlagBag extends SecureList
{
    public static function from(iterable $flags): self
    {
        return new self($flags);
    }

    public static function type(): string
    {
        return BackedEnum::class;
    }
}
