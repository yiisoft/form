<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

use function array_merge;
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
    private string $header = '<p>' . 'Please fix the following errors:' . '</p>';
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
     * See {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     */
    public function footer(string $value): self
    {
        $new = clone $this;
        $new->footer = $value;
        return $new;
    }

    /**
     * Set the header text for the error summary
     *
     * @param string $value
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;
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
        if ($value === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * Return array of the validation errors.
     *
     * @param bool $encode if set to false then the error messages won't be encoded.
     * @param bool $showAllErrors if set to true every error message for each attribute will be shown otherwise only
     * the first error message for each attribute will be shown.
     *
     * @return array of the validation errors.
     */
    private function collectErrors(bool $encode, bool $showAllErrors): array
    {
        $new = clone $this;

        $lines = [];

        foreach ([$new->formModel] as $form) {
            $lines = array_unique(array_merge($lines, $form->getErrorSummary($showAllErrors)));
        }

        /**
         * If there are the same error messages for different attributes, array_unique will leave gaps between
         * sequential keys. Applying array_values to reorder array keys.
         */
        $lines = array_values($lines);

        if ($encode) {
            /** @var string $line */
            foreach ($lines as &$line) {
                $line = Html::encode($line);
            }
        }

        return $lines;
    }

    /**
     * Generates a summary of the validation errors.
     *
     * @return string the generated error summary
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @var array<string, string> */
        $lines = $new->collectErrors($new->encode, $new->showAllErrors);

        if (empty($lines)) {
            /** still render the placeholder for client-side validation use */
            $content = '<ul></ul>';
            $new->attributes['style'] = isset($new->attributes['style'])
                ? rtrim((string)$new->attributes['style'], ';') . '; display:none' : 'display:none';
        } else {
            $content = '<ul><li>' . implode("</li>\n<li>", $lines) . '</li></ul>';
        }

        if ($new->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        return CustomTag::name($new->tag)
            ->attributes($new->attributes)
            ->encode(false)
            ->content($new->header . $content . $new->footer)
            ->render();
    }
}
