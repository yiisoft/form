<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Widget\Attribute\DateAttributes;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Attribute\ModelAttributes;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Widget\Widget;

/*
 * The input element with a type attribute whose value is "date" represents a control for setting the element’s value to
 * a string representing a date.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date
 */
final class Date extends Widget
{
    use DateAttributes;
    use InputAttributes;
    use ModelAttributes;

    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.value */
        $value = HtmlForm::getAttributeValue($new->getFormModel(), $new->attribute);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('Date widget requires a string or null value.');
        }

        return Input::tag()
            ->type('date')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name(HtmlForm::getInputName($new->getFormModel(), $new->attribute))
            ->value($value === '' ? null : $value)
            ->render();
    }
}
