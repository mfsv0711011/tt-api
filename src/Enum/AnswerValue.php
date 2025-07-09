<?php

namespace App\Enum;

enum AnswerValue: string
{
    case YES = 'yes';
    case NO = 'no';

    public function label(): string
    {
        return match ($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }

    public static function fromBoolean(bool $value): self
    {
        return $value ? self::YES : self::NO;
    }

    public function toBoolean(): bool
    {
        return $this === self::YES;
    }
}
