<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormInterface;
use Yiisoft\Form\FormHtml;
use Yiisoft\Widget\Widget as AbstractWidget;

abstract class Widget extends AbstractWidget
{
    use WidgetInputOptions;

    protected ?string $id = null;
    protected FormInterface $form;
    protected string $attribute;
    protected array $options = [];

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string|null $value
     *
     * @return self Id of the widget.
     */
    public function id(?string $value): self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Form structure data entry of the widget.
     *
     * @param FormInterface $value
     *
     * @return self
     */
    public function form(FormInterface $value): self
    {
        $this->form = $value;

        return $this;
    }

    /**
     * The attribute name or expression.
     *
     * @param string $value
     *
     * @return self
     *
     * {@see \Yiisoft\Html\FormHTml::getAttributeName()} for the format about attribute expression.
     */
    public function attribute(string $value): self
    {
        $this->attribute = $value;

        return $this;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }
}
