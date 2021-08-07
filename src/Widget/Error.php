<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\CustomTag;

/**
 * The Error widget displays an error message.
 */
final class Error extends Widget
{
    private string $message = '';

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
    public function messageCallback(array $value = []): self
    {
        $new = clone $this;
        $new->attributes['messageCallback'] = $value;
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
     * The tag name of the container element.
     *
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param null $value
     *
     * @return static
     */
    public function tag(string $value = ''): self
    {
        $new = clone $this;
        $new->attributes['tag'] = $value;
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

        /** @var bool */
        $encode = $new->attributes['encode'] ?? true;

        $error = $new->message !== '' ? $new->message : $new->getFirstError();

        $tag = ArrayHelper::remove($new->attributes, 'tag', 'div');

        /** @var null|array */
        $messageCallback = $new->attributes['messageCallback'] ?? null;

        if ($messageCallback !== null) {
            $error = $messageCallback($new->getFormModel(), $new->getAttribute());
        }

        unset($new->attributes['messageCallback']);

        return $tag !== ''
            ? CustomTag::name($tag)->attributes($new->attributes)->content($error)->encode($encode)->render()
            : $error;
    }
}
