<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Form\Widget\Attribute\ModelAttributes;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * The Error widget displays an error message.
 *
 * @psalm-suppress MissingConstructor
 */
final class Error extends Widget
{
    private string $attribute = '';
    private bool $encode = true;
    private FormModelInterface $formModel;
    private string $message = '';
    private array $messageCallback = [];
    private string $tag = 'div';
    private array $tagAttributes = [];

    /**
     * Specify a form, its attribute.
     *
     * @param FormModelInterface $formModel Form instance.
     * @param string $attribute Form model's property name this widget is rendered for.
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function config(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * Error message to display.
     *
     * @return static
     */
    public function message(string $value): self
    {
        $new = clone $this;
        $new->message = $value;
        return $new;
    }

    /**
     * Callback that will be called to obtain an error message.
     *
     * The signature of the callback must be:
     *
     * ```php
     * [$FormModel, function()]
     * ```
     *
     * @param array $value
     *
     * @return static
     */
    public function messageCallback(array $value): self
    {
        $new = clone $this;
        $new->messageCallback = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param string $value
     *
     * @return static
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * HTML attributes for the widget container tag.
     *
     * @param array $value
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function tagAttributes(array $value): self
    {
        $new = clone $this;
        $new->tagAttributes = $value;
        return $new;
    }

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    protected function run(): string
    {
        $new = clone $this;
        $error = HtmlFormErrors::getFirstError($new->formModel, $new->attribute);

        if ($error !== '' && $new->message !== '') {
            $error = $new->message;
        }

        if ($error !== '' && $new->messageCallback !== []) {
            /** @var string */
            $error = call_user_func($new->messageCallback, $new->formModel, $new->attribute);
        }

        $html = $new->tag !== ''
            ? CustomTag::name($new->tag)
                ->attributes($new->tagAttributes)
                ->content($error)
                ->encode($new->encode)
                ->render()
            : $error;

        return $error !== '' ? $html : '';
    }
}
