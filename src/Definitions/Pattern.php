<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators;

interface Pattern
{
    public function evaluate(string $value): bool;

    public function format(string $value): mixed;
}