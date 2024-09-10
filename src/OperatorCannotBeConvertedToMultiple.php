<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine;

use InvalidArgumentException;
use Vaened\CriteriaCore\Keyword\FilterOperator;

use function sprintf;

final class OperatorCannotBeConvertedToMultiple extends InvalidArgumentException
{
    public function __construct(FilterOperator $operator)
    {
        parent::__construct(sprintf('The <%s> operator cannot convert a multiple search type', $operator->name));
    }
}
