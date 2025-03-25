<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

use function is_string;

/**
 * Represents `<input>` element of type "hidden" are let web developers include data that cannot be seen or modified by
 * users when a form is submitted
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#hidden-state-(type=hidden)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/hidden
 */
final class Hidden extends InputField
{
    protected function beforeRender(): void
    {
        $this->template = '{input}';
        $this->useContainer = false;
        $this->inputContainerTag = null;
        $this->beforeInput = '';
        $this->afterInput = '';
    }

    protected function generateInput(): string
    {
        $value = $this->getValue();

        if (!is_string($value) && !is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Hidden widget requires a string, numeric or null value.');
        }

        $inputAttributes = $this->getInputAttributes();

        return Html::hiddenInput($this->getName(), $value, $inputAttributes)->render();
    }
}
