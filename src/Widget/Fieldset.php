<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * The <fieldset> HTML element is used to group several controls as well as labels (<label>) within a web form.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-fieldset-element
 */
final class Fieldset extends Widget
{
    private array $attributes = [];
    private ?string $legend = null;
    private array $legendAttributes = [];

    /**
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public function begin(): string
    {
        parent::begin();

        $html = Html::openTag('fieldset', $this->attributes);

        if ($this->legend !== null) {
            $html .= PHP_EOL .
                CustomTag::name('legend')
                    ->attributes($this->legendAttributes)
                    ->content($this->legend)
                    ->render();
        }

        return $html;
    }

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
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
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#autofocusing-a-form-control-the-autofocus-attribute
     */
    public function autofocus(): self
    {
        $new = clone $this;
        $new->attributes['autofocus'] = true;
        return $new;
    }

    /**
     * Set CSS class of the field widget.
     *
     * @param string $class
     *
     * @return self
     */
    public function class(string $class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to `false` to enable the element again, which is not the case.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = true;
        return $new;
    }

    /**
     * Set the ID of the widget.
     *
     * @param string|null $id
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * The <legend> HTML element represents a caption for the content of its parent <fieldset>.
     *
     * @param string|null $value whether the legend is enabled or disabled.
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-legend-element
     */
    public function legend(?string $value): self
    {
        $new = clone $this;
        $new->legend = $value;
        return $new;
    }

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function legendAttributes(array $values): self
    {
        $new = clone $this;
        $new->legendAttributes = $values;
        return $new;
    }

    /**
     * The name part of the name/value pair associated with this element for the purposes of form submission.
     *
     * @param string|null The name of the widget.
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-name
     */
    public function name(?string $value): self
    {
        $new = clone $this;
        $new->attributes['name'] = $value;
        return $new;
    }

    /**
     * The title global attribute contains text representing advisory information related to the element it belongs to.
     *
     * @param string $value
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-title
     */
    public function title(string $value): self
    {
        $new = clone $this;
        $new->attributes['title'] = $value;
        return $new;
    }

    /**
     * Generates a form end tag.
     *
     * @return string the generated tag.
     *
     * {@see beginForm()}
     */
    protected function run(): string
    {
        return Html::closeTag('fieldset') . PHP_EOL;
    }
}
