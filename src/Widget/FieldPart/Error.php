<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\FieldPart;

use Yiisoft\Form\Exception\AttributeNotSetException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * The Error widget displays an error message.
 */
final class Error extends Widget
{
    private string $attribute = '';
    private array $attributes = [];
    private bool $encode = false;
    private string $message = '';
    private array $messageCallback = [];
    private string $tag = 'div';
    private ?FormModelInterface $formModel = null;

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;
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
     * @return static
     */
    public function for(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
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
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    protected function run(): string
    {
        $error = HtmlFormErrors::getFirstError($this->getFormModel(), $this->getAttribute());

        if ($error !== '' && $this->message !== '') {
            $error = $this->message;
        }

        if ($error !== '' && $this->messageCallback !== []) {
            /** @var string */
            $error = call_user_func($this->messageCallback, $this->getFormModel(), $this->getAttribute());
        }

        return match ($this->tag !== '' && $error !== '') {
            true => CustomTag::name($this->tag)
                ->attributes($this->attributes)
                ->content($error)
                ->encode($this->encode)
                ->render(),
            false => $error,
        };
    }

    private function getAttribute(): string
    {
        return match (empty($this->attribute)) {
            true => throw new AttributeNotSetException(),
            false => $this->attribute,
        };
    }

    /**
     * Return FormModelInterface object.
     *
     * @return FormModelInterface
     */
    private function getFormModel(): FormModelInterface
    {
        return match (empty($this->formModel)) {
            true => throw new FormModelNotSetException(),
            false => $this->formModel,
        };
    }
}
