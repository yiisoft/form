<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\BaseField;

final class StubBaseField extends BaseField
{
    public function __construct(
        private ?string $content = 'test',
        private ?string $beginContent = null,
        private ?string $endContent = null,
        private ?string $beforeRenderBeginContent = null,
        private ?string $beforeRenderEndContent = null,
    ) {
    }

    protected function beforeRender(): void
    {
        if ($this->beforeRenderBeginContent !== null) {
            $this->beginContent = $this->beforeRenderBeginContent;
        }
        if ($this->beforeRenderEndContent !== null) {
            $this->endContent = $this->beforeRenderEndContent;
        }
    }

    protected function generateContent(): ?string
    {
        return $this->content;
    }

    protected function generateBeginContent(): string
    {
        return $this->beginContent ?? parent::generateBeginContent();
    }

    protected function generateEndContent(): string
    {
        return $this->endContent ?? parent::generateEndContent();
    }
}
