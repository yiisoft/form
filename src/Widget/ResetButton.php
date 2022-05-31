<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Widget\Attribute\ButtonAttributes;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "reset" represents a button for resetting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.reset.html#input.reset
 */
final class ResetButton extends ButtonAttributes
{
    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes, '-reset');

        return Input::tag()
            ->type('reset')
            ->attributes($attributes)
            ->render();
    }
}
