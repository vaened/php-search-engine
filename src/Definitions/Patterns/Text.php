<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators\Aspects\Regex;

use Vaened\SearchEngine\Evaluators\Aspects\Regex;

final class Text extends Regex
{
    public function format(string $value): string
    {
        return $value;
    }

    protected function pattern(): string
    {
        return '/^(?!\s*$).+/';
    }
}
