<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Error extends Widget
{
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    public function run(): string
    {
        $new = clone $this;

        $errorSource = ArrayHelper::remove($new->options, 'errorSource');

        if ($errorSource !== null) {
            $error = $errorSource($new->data, $new->attribute);
        } else {
            $error = $new->data->getFirstError(HtmlForm::getAttributeName($new->attribute));
        }

        $tag = ArrayHelper::remove($new->options, 'tag', 'div');

        return Html::tag($tag, $error, $new->options);
    }

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
    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
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
     * @return self
     */
    public function errorSource(array $value = []): self
    {
        $new = clone $this;
        $new->options['errorSource'] = $value;
        return $new;
    }

    /**
     * Whether to HTML-encode the error messages.
     *
     * Defaults to true. This option is ignored if item option is set.
     *
     * @param bool $value
     *
     * @return self
     */
    public function noEncode(bool $value = false): self
    {
        $new = clone $this;
        $new->options['encode'] = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Null to render error messages without container {@see Html::tag()}.
     *
     * @param string|null $value
     *
     * @return self
     */
    public function tag(?string $value = null): self
    {
        $new = clone $this;
        $new->options['tag'] = $value;
        return $new;
    }
}
