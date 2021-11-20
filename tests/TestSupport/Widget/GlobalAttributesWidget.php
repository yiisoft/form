<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Widget;

use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class GlobalAttributesWidget extends Widget
{
    use GlobalAttributes;

    private array $attributes = [];

    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    protected function run(): string
    {
        $new = clone $this;

        return '<test' . Html::renderTagAttributes($new->attributes) . '>';
    }
}
