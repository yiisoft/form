<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Widget\Widget;

/**
 * The input element with a type attribute whose value is "submit" represents a button for submitting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html
 */
final class SubmitButton extends Widget
{
    use GlobalAttributes;

    private array $attributes = [];

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $submit = Input::submitButton();

        if ($new->autoIdPrefix === '') {
            $new->autoIdPrefix = 'submit-';
        }

        $id = $new->getIdWithoutModel();
        /** @var string|null */
        $name = $new->attributes['name'] ?? $id;

        return $submit->attributes($new->attributes)->id($id)->name($name)->render();
    }
}
