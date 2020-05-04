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
    public function errorCss(string $value): self;
    public function errorSummaryCss(string $value): self;
    public function inputCss(string $value): self;
    public function requiredCss(string $value): self;
    public function successCss(string $value): self;
    public function template(string $value): self;
    public function validatingCss(string $value): self;
    public function validationStateOn(string $value): self;
}
