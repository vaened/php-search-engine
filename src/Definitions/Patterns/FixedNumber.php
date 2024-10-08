<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Definitions\Patterns;

final class FixedNumber extends Number
{
    public function __construct(int $length)
    {
        parent::__construct($length, $length);
    }
}
