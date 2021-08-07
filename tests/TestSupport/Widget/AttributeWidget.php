<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Widget;

use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Form\Widget\Attribute\DateAttribute;
use Yiisoft\Form\Widget\Widget;
use Yiisoft\Html\Html;

final class AttributeWidget extends Widget
{
    use CommonAttribute;
    use DateAttribute;

    protected function run(): string
    {
        $new = clone $this;

        return '<test' . Html::renderTagAttributes($new->attributes) . '>';
    }
}
