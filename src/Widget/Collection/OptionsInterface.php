<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;

interface OptionsInterface
{
    public function config(FormInterface $data, string $attribute, array $options = []): self;
    public function charset(string $value): self;
    public function addLabel(bool $value = true): self;
    public function addPlaceholder(bool $generate = true, ?string $value = null): void;
}
