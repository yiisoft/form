<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\CustomTag;

final class Error extends Widget
{
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
    public function errorSource(array $value = []): self
    {
        $new = clone $this;
        $new->attributes['errorSource'] = $value;
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

        /** @var null|array */
        $errorSource = $new->attributes['errorSource'] ?? null;

        $tag = ArrayHelper::remove($new->attributes, 'tag', 'div');

        if ($errorSource !== null) {
            $error = $errorSource($new->getFormModel(), $new->getAttribute());
        } else {
            $error = $new->getFirstError();
        }

        unset($new->attributes['errorSource']);

        return $tag !== ''
            ? CustomTag::name($tag)->attributes($new->attributes)->content($error)->encode($encode)->render()
            : $error;
    }
}
