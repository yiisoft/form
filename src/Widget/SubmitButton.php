<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Widget\Widget;

/**
 * The input element with a type attribute whose value is "submit" represents a button for submitting a form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html
 */
final class SubmitButton extends Widget
{
    use CommonAttribute;

    private string $autoIdPrefix = 'submit-';
    private array $attributes = [];
    private string $id = '';
    private string $name = '';
    private string $value = '';
    private static int $counter = 0;

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @param string $value
     *
     * @return static
     */
    public function autoIdPrefix(string $value): self
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;
        return $new;
    }

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
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(string $id): self
    {
        $new = clone $this;
        $new->id = $id;
        return $new;
    }

    /**
     * The name part of the name/value pair associated with this element for the purposes of form submission.
     *
     * @param string The name of the widget.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.reset.html#input.reset.attrs.name
     */
    public function name(string $value): self
    {
        $new = clone $this;
        $new->name = $value;
        return $new;
    }

    /**
     * Counter used to generate {@see id} for widgets.
     *
     * @param int $value
     */
    public static function counter(int $value): void
    {
        self::$counter = $value;
    }

    /**
     * Specifies a value for the input element.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html#input.submit.attrs.value
     */
    public function value(string $value): self
    {
        $new = clone $this;
        $new->value = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $submit = Input::submitButton();

        $id = $new->id !== '' ? $new->id : $new->autoIdPrefix . self::$counter++;
        $name = $new->name !== '' ? $new->name : $id;

        if ($new->value !== '') {
            $submit = $submit->value($new->value);
        }
        return $submit->attributes($new->attributes)->id($id)->name($name)->render();
    }
}
