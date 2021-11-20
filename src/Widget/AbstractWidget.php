<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Widget\Widget;

abstract class AbstractWidget extends Widget
{
    protected array $attributes = [];
    private string $attribute = '';
    private bool $encode = true;
    private ?FormModelInterface $formModel = null;

    /**
     * Add Html attribute.
     *
     * @param string $key attribute name.
     * @param mixed $value attribute value.
     *
     * @return static
     */
    public function addAttribute(string $key, $value): self
    {
        $new = clone $this;
        $new->attributes[$key] = $value;
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

        if ($value !== []) {
            $new->attributes = $value;
        }

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

    protected function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new InvalidArgumentException('Attribute is not set.');
        }

        return $this->attribute;
    }

    protected function getEncode(): bool
    {
        return $this->encode;
    }

    /**
     * Return FormModelInterface object.
     *
     * @return FormModelInterface
     */
    protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    /**
     * Generates a unique ID for the attribute, if it does not have one yet.
     *
     * @return string|null
     */
    protected function getId(): ?string
    {
        $id = ArrayHelper::remove($this->attributes, 'id', '');

        if (!is_string($id) && null !== $id) {
            throw new InvalidArgumentException('Attribute "id" must be a string or null.');
        }

        if ($id === '') {
            $id = HtmlForm::getInputId($this->getFormModel(), $this->attribute);
        }

        return $id ?? null;
    }

    /**
     * Generate name for the widget.
     *
     * @return string
     */
    protected function getName(): string
    {
        $name = $this->attributes['name'] ?? HtmlForm::getInputName($this->getFormModel(), $this->attribute);

        if (!is_string($name)) {
            throw new InvalidArgumentException('Attribute "name" must be a string.');
        }

        return $name;
    }
}
