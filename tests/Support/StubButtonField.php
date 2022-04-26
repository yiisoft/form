<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\ButtonField;

final class StubButtonField extends ButtonField
{
    protected function getType(): string
    {
        return 'button';
    }
}
