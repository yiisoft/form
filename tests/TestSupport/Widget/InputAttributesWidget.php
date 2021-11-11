<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Widget;

use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class InputAttributesWidget extends Widget
{
    use InputAttributes;

    private array $attributes = [];

    protected function run(): string
    {
        $new = clone $this;

        return '<test' . Html::renderTagAttributes($new->attributes) . '>';
    }
}
