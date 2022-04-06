<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\DirnameTrait;
use Yiisoft\Form\Field\Base\MinMaxLengthTrait;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ReadonlyTrait;
use Yiisoft\Form\Field\Base\RequiredTrait;
use Yiisoft\Html\Html;

use function is_string;

final class Textarea extends AbstractField
{
    use DirnameTrait;
    use MinMaxLengthTrait;
    use PlaceholderTrait;
    use ReadonlyTrait;
    use RequiredTrait;

    /**
     * The expected maximum number of characters per line of text to show.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-cols
     */
    public function cols(?int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['cols'] = $value;
        return $new;
    }

    /**
     * The number of lines of text to show.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-rows
     */
    public function rows(?int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['rows'] = $value;
        return $new;
    }

    /**
     * Define how the value of the form control is to be wrapped for form submission:
     *  - `hard` indicates that the text in the `textarea` is to have newlines added by the user agent so that the text
     *    is wrapped when it is submitted.
     *  - `soft` indicates that the text in the `textarea` is not to be wrapped when it is submitted (though it can
     *    still be wrapped in the rendering).
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-wrap
     */
    public function wrap(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['wrap'] = $value;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Textarea widget must be a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::textarea($this->getInputName(), $value, $tagAttributes)->render();
    }
}
