<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Placeholder;

use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderTrait;

class BasePlaceholder extends InputField implements PlaceholderInterface
{
    use PlaceholderTrait;
}
