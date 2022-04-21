<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\ValidationClass;

interface ValidationClassInterface
{
    public function invalidClass(string $class): self;

    public function validClass(string $class): self;
}
