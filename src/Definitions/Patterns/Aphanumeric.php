<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Definitions\Patterns;

final class Aphanumeric extends Regex
{
    public function format(string $value): string
    {
        return $value;
    }

    protected function pattern(): string
    {
        return '^[\w\,\ ]+$';
    }
}
