<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Form\Widget\Attribute\WithoutModelAttribute;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Widget\Widget;

/**
 * The input element with a type attribute whose value is "image" represents either an image from which the UA enables a
 * user to interactively select a pair of coordinates and submit the form, or alternatively a button from which the user
 * can submit the form.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.image.html#input.image
 */
final class Image extends Widget
{
    use CommonAttribute;
    use WithoutModelAttribute;

    /**
     * Provides a textual label for an alternative button for users and UAs who cannot use the image specified by the
     * src attribute.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.image.html#input.image.attrs.alt
     */
    public function alt(string $value): self
    {
        $new = clone $this;
        $new->attributes['alt'] = $value;
        return $new;
    }

    /**
     * The height of the image, in CSS pixels.
     *
     * @param int $value
     *
     * @return static
     *
     *  @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.image.html#input.image.attrs.height
     */
    public function height(int $value): self
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Height must be greater than or equal to 0.');
        }

        $new = clone $this;
        $new->attributes['height'] = $value;
        return $new;
    }

    /**
     * A list of one or more strings separated by commas indicating the size of the font.
     *
     * @param array<array-key, string> $value
     *
     * ```php
     * [
     *    '(max-width: 320px) 280px',
     *    '(max-width: 480px) 480px',
     *    '800px', // default size
     * ]
     *
     * @return static
     *
     * @link https://developer.mozilla.org/es/docs/Web/HTML/Element/img#attr-sizes
     */
    public function sizes(array $value): self
    {
        $new = clone $this;
        $new->attributes['sizes'] = implode(',', $value);
        return $new;
    }

    /**
     * Specifies the location of an image.
     *
     * @param string $value The location of an image.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.image.html#input.image.attrs.src
     */
    public function src(string $value): self
    {
        $new = clone $this;
        $new->attributes['src'] = $value;
        return $new;
    }

    /**
     * A list of one or more strings separated by commas indicating the possible fonts to use.
     *
     * @param array $value
     *
     * ```php
     * [
     *     '100w' => '/example-100w',
     *     '500w' => '/example-500w',
     *     '1500w' => '/example-1500w',
     * ]
     * ```
     *
     * @return static
     *
     * @link https://developer.mozilla.org/es/docs/Web/HTML/Element/img#attr-srcset
     *
     * {@see size}
     */
    public function srcset(array $value): self
    {
        $new = clone $this;
        $new->attributes['srcset'] = $value;
        return $new;
    }

    /**
     * The width of the image, in CSS pixels.
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.image.html#input.image.attrs.width
     */
    public function width(int $value): self
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Width must be greater than or equal to 0.');
        }

        $new = clone $this;
        $new->attributes['width'] = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;
        $img = Input::tag()->type('image');

        if ($new->autoIdPrefix === '') {
            $new->autoIdPrefix = 'image-';
        }

        return $img->attributes($new->attributes)->id($new->getId())->name($new->getName())->render();
    }
}
