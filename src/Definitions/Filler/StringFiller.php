<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\SearchEngine\Evaluators;

use function str_pad;

final class StringFiller
{
    public function __construct(
        private readonly string   $character,
        private readonly int      $length,
        private readonly FillType $type = FillType::Left
    )
    {
    }

    public static function from(string $character, int $length): self
    {
        return new self($character, $length);
    }

    public function length(): int
    {
        return $this->length;
    }

    public function fill(string|int $value): string
    {
        return str_pad($value, $this->length, $this->character, $this->type->value);
    }
}
