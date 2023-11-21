<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;

/**
 * Displays a summary of the form validation errors. If there is no validation error, field will be hidden.
 */
final class ErrorSummary extends BaseField
{
    private ?FormModelInterface $formModel = null;
    private bool $encode = true;

    private bool $showAllErrors = false;
    private array $onlyAttributes = [];

    private string $footer = '';
    private array $footerAttributes = [];
    private string $header = 'Please fix the following errors:';
    private array $headerAttributes = [];
    private array $listAttributes = [];

    public function formModel(FormModelInterface $formModel): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
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

    /**
     * Whether to show all errors.
     */
    public function showAllErrors(bool $value = true): self
    {
        $new = clone $this;
        $new->showAllErrors = $value;
        return $new;
    }

    /**
     * Specific attributes to be filtered out when rendering the error summary.
     *
     * @param array $names The attribute names to be included in error summary.
     */
    public function onlyAttributes(string ...$names): self
    {
        $new = clone $this;
        $new->onlyAttributes = $names;
        return $new;
    }

    /**
     * Use only common errors when rendering the error summary.
     */
    public function onlyCommonErrors(): self
    {
        $new = clone $this;
        $new->onlyAttributes = [''];
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
    final public function addListClass(?string ...$class): self
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
    final public function listClass(?string ...$class): static
    {
        $new = clone $this;
        $new->listAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    protected function generateContent(): ?string
    {
        $messages = $this->collectErrors();
        if (empty($messages)) {
            return null;
        }

        $content = [];

        if ($this->header !== '') {
            $content[] = Html::p($this->header, $this->headerAttributes)->render();
        }

        $content[] = Html::ul()
            ->attributes($this->listAttributes)
            ->strings($messages, [], $this->encode)
            ->render();

        if ($this->footer !== '') {
            $content[] = Html::p($this->footer, $this->footerAttributes)->render();
        }

        return implode("\n", $content);
    }

    /**
     * Return array of the validation errors.
     *
     * @return string[] Array of the validation errors.
     */
    private function collectErrors(): array
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        $errors = HtmlFormErrors::getErrorSummaryFirstErrors($this->formModel);

        if ($this->showAllErrors) {
            $errors = HtmlFormErrors::getErrorSummary($this->formModel, $this->onlyAttributes);
        } elseif ($this->onlyAttributes !== []) {
            $errors = array_intersect_key($errors, array_flip($this->onlyAttributes));
        }

        /**
         * If there are the same error messages for different attributes, array_unique will leave gaps between
         * sequential keys. Applying array_values to reorder array keys.
         *
         * @var string[]
         */
        return array_values(array_unique($errors));
    }
}
