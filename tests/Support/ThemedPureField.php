<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Factory\PureField;

final class ThemedPureField extends PureField
{
    protected const DEFAULT_THEME = 'default';
}
