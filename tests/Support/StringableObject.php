<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

final class StringableObject
{
    private string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
