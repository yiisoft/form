<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\Field\Base\InputData\InputDataWithCustomNameAndValueTrait;
use Yiisoft\Form\Field\Base\InputTag\InputTagMethodsTrait;

/**
 * Base class for fields that render a simple input tag without template/label/hint/error/container features.
 *
 * @see PartsField for fields that support templates, labels, hints, and errors.
 */
abstract class InputTagField extends BaseField
{
    use InputDataWithCustomNameAndValueTrait;
    use InputTagMethodsTrait;

    protected bool $useContainer = false;

    final protected function generateContent(): ?string
    {
        return $this->generateInput();
    }

    abstract protected function generateInput(): string;
}
