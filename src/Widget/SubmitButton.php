<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Widget\Attribute\ButtonAttributes;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "submit" represents a button for submitting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html
 */
final class SubmitButton extends ButtonAttributes
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes, '-submit');

        return Input::tag()
            ->type('submit')
            ->attributes($attributes)
            ->render();
    }
}
