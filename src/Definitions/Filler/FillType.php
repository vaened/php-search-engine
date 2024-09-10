<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators;

enum FillType: int
{
    case Left = 0;

    case Right = 1;

    case Both = 2;
}
