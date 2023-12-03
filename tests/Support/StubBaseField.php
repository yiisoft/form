<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\BaseField;

final class StubBaseField extends BaseField
{
    public function __construct(
        private ?string $content = 'test',
    ) {
    }

    protected function generateContent(): ?string
    {
        return $this->content;
    }
}
