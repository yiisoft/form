<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Html\Tag\CustomTag;

/**
 * The Error widget displays an error message.
 *
 * @psalm-suppress MissingConstructor
 */
final class Error extends AbstractForm
{
    private string $message = '';
    private array $messageCallback = [];
    private string $tag = 'div';

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
        $new = clone $this;
        $error = HtmlFormErrors::getFirstError($new->getFormModel(), $new->getAttribute());

        if ($error !== '' && $new->message !== '') {
            $error = $new->message;
        }

        if ($error !== '' && $new->messageCallback !== []) {
            /** @var string */
            $error = call_user_func($new->messageCallback, $new->getFormModel(), $new->getAttribute());
        }

        $html = $new->tag !== ''
            ? CustomTag::name($new->tag)
                ->attributes($new->attributes)
                ->content($error)
                ->encode($new->getEncode())
                ->render()
            : $error;

        return $error !== '' ? $html : '';
    }
}
