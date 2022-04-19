<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Stringable;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Html\Html;

/**
 * @link https://html.spec.whatwg.org/multipage/input.html#image-button-state-(type=image)
 */
final class Image extends PartsField
{
    private array $inputTagAttributes = [];

    /**
     * Provides the textual label for the button for users and user agents who cannot use the image.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-alt
     */
    public function alt(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['alt'] = $value;
        return $new;
    }

    public function width(int|string|Stringable|null $width): self
    {
        $new = clone $this;
        $new->inputTagAttributes['width'] = $width;
        return $new;
    }

    public function height(int|string|Stringable|null $height): self
    {
        $new = clone $this;
        $new->inputTagAttributes['height'] = $height;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-src
     */
    public function src(?string $url): self
    {
        $new = clone $this;
        $new->inputTagAttributes['src'] = $url;
        return $new;
    }

    public function disabled(?bool $disabled = true): self
    {
        $new = clone $this;
        $new->inputTagAttributes['disabled'] = $disabled;
        return $new;
    }

    public function inputTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputTagAttributes = $attributes;
        return $new;
    }

    protected function generateInput(): string
    {
        return Html::input(
            type: 'image',
            attributes: $this->inputTagAttributes
        )->render();
    }
}
