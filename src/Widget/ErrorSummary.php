<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Ul;
use Yiisoft\Widget\Widget;

use function array_unique;
use function array_values;

/**
 * The error summary widget displays a summary of the errors in a form.
 *
 * @psalm-suppress MissingConstructor
 */
final class ErrorSummary extends Widget
{
    private array $attributes = [];
    private bool $encode = true;
    private FormModelInterface $formModel;
    private string $footer = '';
    private array $footerAttributes = [];
    private string $header = 'Please fix the following errors:';
    private array $headerAttributes = [];
    private bool $showAllErrors = false;
    /** @psalm-param non-empty-string */
    private string $tag = 'div';

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * Set the footer text for the error summary
     *
     * @param string $value
     *
     * @return static
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
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function footerAttributes(array $values): self
    {
        $new = clone $this;
        $new->footerAttributes = $values;
        return $new;
    }

    /**
     * Set the header text for the error summary
     *
     * @param string $value
     *
     * return static
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
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerAttributes = $values;
        return $new;
    }

    /**
     * Set the model for the error summary.
     *
     * @param FormModelInterface $formModel
     *
     * @return static
     */
    public function model(FormModelInterface $formModel): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        return $new;
    }

    /**
     * Whether to show all errors.
     *
     * @param bool $value
     *
     * @return static
     */
    public function showAllErrors(bool $value): self
    {
        $new = clone $this;
        $new->showAllErrors = $value;
        return $new;
    }

    /**
     * Set the container tag name for the error summary.
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
     * Return array of the validation errors.
     *
     * @return array of the validation errors.
     */
    private function collectErrors(): array
    {
        $errors = HtmlFormErrors::getErrorSummaryFirstErrors($this->formModel);
        $errorMessages = [];

        if ($this->showAllErrors) {
            $errors = HtmlFormErrors::getErrorSummary($this->formModel);
        }

        /**
         * If there are the same error messages for different attributes, array_unique will leave gaps between
         * sequential keys. Applying array_values to reorder array keys.
         */
        $lines = array_values(array_unique($errors));

        if ($this->encode) {
            /** @var string $line */
            foreach ($lines as $line) {
                if (!empty($line)) {
                    $errorMessages[] = Html::encode($line);
                }
            }
        }

        return $errorMessages;
    }

    /**
     * Generates a summary of the validation errors.
     *
     * @return string the generated error summary
     */
    protected function run(): string
    {
        $attributes = $this->attributes;
        $content = '';

        if ($this->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $content .=  P::tag()->attributes($this->headerAttributes)->content($this->header)->render() . PHP_EOL;

        /** @var array<string, string> */
        $lines = $this->collectErrors();
        $content .= Ul::tag()->strings($lines)->render();

        if ($this->footer !== '') {
            $content .= PHP_EOL . P::tag()->attributes($this->footerAttributes)->content($this->footer)->render();
        }

        return $lines !== []
            ? CustomTag::name($this->tag)
                ->attributes($attributes)
                ->encode(false)
                ->content(PHP_EOL . $content . PHP_EOL)
                ->render()
            : '';
    }
}
