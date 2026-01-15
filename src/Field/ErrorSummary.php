<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;

use function in_array;
use function array_slice;

use const ARRAY_FILTER_USE_KEY;

/**
 * @psalm-type Errors = array<string,list<string>>
 */
final class ErrorSummary extends BaseField
{
    /**
     * @psalm-var Errors
     */
    private array $errors = [];
    private bool $encode = true;
    private bool $onlyFirst = false;
    private array $onlyProperties = [];

    private string $footer = '';
    private array $footerAttributes = [];

    /**
     * @var non-empty-string|null
     */
    private ?string $headerTag = 'div';
    private string $header = '';
    private bool $headerEncode = true;
    private array $headerAttributes = [];

    private array $listAttributes = [];

    /**
     * @psalm-param Errors $errors
     */
    public function errors(array $errors): self
    {
        $new = clone $this;
        $new->errors = $errors;
        return $new;
    }

    /**
     * Whether error content should be HTML-encoded.
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    public function onlyFirst(bool $value = true): self
    {
        $new = clone $this;
        $new->onlyFirst = $value;
        return $new;
    }

    /**
     * Specific properties to be filtered out when rendering the error summary.
     *
     * @param array $names The property names to be included in error summary.
     */
    public function onlyProperties(string ...$names): self
    {
        $new = clone $this;
        $new->onlyProperties = $names;
        return $new;
    }

    /**
     * Use only common errors when rendering the error summary.
     */
    public function onlyCommonErrors(): self
    {
        $new = clone $this;
        $new->onlyProperties = [''];
        return $new;
    }

    /**
     * Set the footer text for the error summary
     */
    public function footer(string $value): self
    {
        $new = clone $this;
        $new->footer = $value;
        return $new;
    }

    /**
     * Set footer attributes for the error summary.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * See {@see Html::renderTagAttributes} for details on how attributes are being rendered.
     */
    public function footerAttributes(array $values): self
    {
        $new = clone $this;
        $new->footerAttributes = $values;
        return $new;
    }

    /**
     * Set the header text for the error summary
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;
        return $new;
    }

    /**
     * Set the header tag name.
     *
     * @param string|null $tag Header tag name.
     */
    public function headerTag(?string $tag): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->headerTag = $tag;
        return $new;
    }

    /**
     * Whether header content should be HTML-encoded.
     */
    public function headerEncode(bool $encode): self
    {
        $new = clone $this;
        $new->headerEncode = $encode;
        return $new;
    }

    /**
     * Set header attributes for the error summary.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * See {@see Html::renderTagAttributes} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerAttributes = $values;
        return $new;
    }

    /**
     * Set errors list container attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * See {@see Html::renderTagAttributes} for details on how attributes are being rendered.
     */
    public function listAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->listAttributes = $attributes;
        return $new;
    }

    /**
     * Add one or more CSS classes to the list container tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function addListClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->listAttributes, $class);
        return $new;
    }

    /**
     * Replace current list container tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function listClass(?string ...$class): self
    {
        $new = clone $this;
        $new->listAttributes['class'] = $class;
        return $new;
    }

    protected function generateContent(): ?string
    {
        $errors = $this->filterErrors();
        if (empty($errors)) {
            return null;
        }

        $content = [];

        if ($this->header !== '') {
            $content[] = $this->headerTag === null
                ? ($this->headerEncode ? Html::encode($this->header) : $this->header)
                : CustomTag::name($this->headerTag)
                    ->attributes($this->headerAttributes)
                    ->content($this->header)
                    ->encode($this->headerEncode)
                    ->render();
        }

        $content[] = Html::ul()
            ->attributes($this->listAttributes)
            ->strings($errors, [], $this->encode)
            ->render();

        if ($this->footer !== '') {
            $content[] = Html::div($this->footer, $this->footerAttributes)->render();
        }

        return implode("\n", $content);
    }

    /**
     * Return array of the validation errors.
     *
     * @return string[] Array of the validation errors.
     */
    private function filterErrors(): array
    {
        if (empty($this->errors)) {
            return [];
        }

        $errors = $this->errors;

        if (!empty($this->onlyProperties)) {
            $errors = array_filter(
                $errors,
                fn(string $property) => in_array($property, $this->onlyProperties, true),
                ARRAY_FILTER_USE_KEY,
            );
        }

        if ($this->onlyFirst) {
            $errors = array_map(
                static fn(array $propertyErrors) => array_slice($propertyErrors, 0, 1),
                $errors,
            );
        }

        $result = [];
        foreach ($errors as $propertyErrors) {
            $result = [...$result, ...$propertyErrors];
        }

        /**
         * If there are the same error messages for different properties, `array_unique` will leave gaps between
         * sequential keys.
         */
        return array_unique($result);
    }
}
