<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormModelInterface;

interface FieldInterface
{
    /**
     * Set form model, name and options for the widget.
     *
     * @param FormModelInterface $data Form model.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $options The HTML attributes for the widget container tag.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return self
     */
    public function config(FormModelInterface $data, string $attribute, array $options = []): self;
    public function ariaAttribute(bool $value): self;
    public function errorCssClass(string $value): self;
    public function errorSummaryCssClass(string $value): self;
    public function inputCssClass(string $value): self;
    public function requiredCssClass(string $value): self;
    public function successCssClass(string $value): self;
    public function template(string $value): self;
    public function validatingCssClass(string $value): self;
    public function validationStateOn(string $value): self;
}
