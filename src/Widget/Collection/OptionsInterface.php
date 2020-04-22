<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;

interface OptionsInterface
{
    public function data(FormInterface $value): self;
    public function attribute(string $value): self;
    public function charset(string $value): self;
    public function type(string $value): self;
    public function options(array $value): self;
}
