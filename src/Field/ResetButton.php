<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\AbstractButtonField;

final class ResetButton extends AbstractButtonField
{
    protected function getType(): string
    {
        return 'reset';
    }
}
