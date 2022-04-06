<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\MinMaxLengthTrait;
use Yiisoft\Form\Field\Base\PatternTrait;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ReadonlyTrait;
use Yiisoft\Form\Field\Base\RequiredTrait;
use Yiisoft\Form\Field\Base\SizeTrait;
use Yiisoft\Html\Html;

use function is_string;

/**
 * Generates a text input tag for the given form attribute.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#text-(type=text)-state-and-search-state-(type=search)
 */
final class Text extends AbstractField
{
    use MinMaxLengthTrait;
    use PatternTrait;
    use PlaceholderTrait;
    use ReadonlyTrait;
    use RequiredTrait;
    use SizeTrait;

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
