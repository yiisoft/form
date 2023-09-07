<?php

declare(strict_types=1);

namespace Yiisoft\Form\Attribute;

use Attribute;

/**
 * Attribute that mark a class property for as non-used on collection.
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
final class SkipCollection
{
}
