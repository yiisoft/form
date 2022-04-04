<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ReadonlyTrait;
use Yiisoft\Form\Field\Base\RequiredTrait;
use Yiisoft\Html\Html;

use function is_string;

/**
 * Generates a text input tag for the given form attribute.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#text-(type=text)-state-and-search-state-(type=search)
 */
final class Text extends InputField
{
    use PlaceholderTrait;
    use ReadonlyTrait;
    use RequiredTrait;

    /**
     * Name of form control to use for sending the element's directionality in form submission
     *
     * @param string $value Any string that is not empty.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-dirname
     */
    public function dirname(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('The value cannot be empty.');
        }

        $new = clone $this;
        $new->inputTagAttributes['dirname'] = $value;
        return $new;
    }

    /**
     * Maximum length of value.
     *
     * @param int $value A limit on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-maxlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-maxlength
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['maxlength'] = $value;
        return $new;
    }

    /**
     * Minimum length of value.
     *
     * @param int $value A lower bound on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-minlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-minlength
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['minlength'] = $value;
        return $new;
    }

    /**
     * Pattern to be matched by the form control's value.
     *
     * @param string $value A regular expression against which the control's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-pattern
     */
    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['pattern'] = $value;
        return $new;
    }

    /**
     * The size of the control.
     *
     * @param int $value The number of characters that allow the user to see while editing the element's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-size
     */
    public function size(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['size'] = $value;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::textInput($this->getInputName(), $value, $tagAttributes)->render();
    }
}
