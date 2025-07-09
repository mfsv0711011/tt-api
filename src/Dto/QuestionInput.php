<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class QuestionInput
{
    public function __construct(
        #[Assert\Valid]
        private Translation $text,
    ) {
    }

    public function getText(): Translation
    {
        return $this->text;
    }
}
