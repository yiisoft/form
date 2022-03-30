<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Validator\NumberInterface;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Input;

use function is_numeric;

/**
 * The input element with a type attribute whose value is "range" represents an imprecise control for setting the
 * element’s value to a string representing a number.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.range.html
 */
final class Range extends InputAttributes implements NumberInterface
{
    private array $outputAttributes = [];
    private string $outputTag = 'output';

    public function max(int $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    public function min(int $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    /**
     * The HTML attributes for output tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function outputAttributes(array $value): self
    {
        $new = clone $this;
        $new->outputAttributes = $value;
        return $new;
    }

    /**
     * The tag name of the output tag.
     *
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param string $value
     *
     * @return self
     */
    public function outputTag(string $value): self
    {
        $new = clone $this;
        $new->outputTag = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);
        $outputAttributes = $this->outputAttributes;

        if (empty($this->outputTag)) {
            throw new InvalidArgumentException('The output tag name it cannot be empty value.');
        }

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.range.html#input.range.attrs.value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (!is_numeric($value) && null !== $value && '' !== $value) {
            throw new InvalidArgumentException('Range widget must be a numeric or null value.');
        }

        $nameOutput = Html::generateId();
        /** @var string|null */
        $outputAttributes['for'] = $attributes['name'] ?? null;
        $outputAttributes['name'] = $nameOutput;
        $attributes['oninput'] = "$nameOutput.value=this.value";

        return
            Input::tag()
                ->type('range')
                ->attributes($attributes)
                ->value($value > 0 ? $value : 0)->render() . PHP_EOL .
            CustomTag::name($this->outputTag)
                ->attributes($outputAttributes)
                ->content($value > 0 ? (string)$value : '0')
                ->id($nameOutput)
                ->render();
    }
}
