<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_merge;
use function array_values;
use function array_unique;

final class ErrorSummary extends Widget
{
    private FormInterface $data;
    private array $options = [];

    /**
     * Generates a summary of the validation errors.
     *
     * @return string the generated error summary
     */
    public function run(): string
    {
        $new = clone $this;

        $header = $new->options['header'] ?? '<p>' . 'Please fix the following errors:' . '</p>';
        $footer = ArrayHelper::remove($new->options, 'footer', '');
        $encode = ArrayHelper::remove($new->options, 'encode', true);
        $showAllErrors = ArrayHelper::remove($new->options, 'showAllErrors', false);

        unset($new->options['header']);

        $lines = $new->collectErrors($encode, $showAllErrors);

        if (empty($lines)) {
            /** still render the placeholder for client-side validation use */
            $content = '<ul></ul>';
            $new->options['style'] = isset($new->options['style'])
                ? rtrim($new->options['style'], ';') . '; display:none' : 'display:none';
        } else {
            $content = '<ul><li>' . implode("</li>\n<li>", $lines) . '</li></ul>';
        }

        return Html::tag('div', $header . $content . $footer, $new->options);
    }

    public function config(FormInterface $data, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->options = $options;
        return $new;
    }

    /**
     * Return array of the validation errors.
     *
     * @param bool $encode, if set to false then the error messages won't be encoded.
     * @param bool $showAllErrors, if set to true every error message for each attribute will be shown otherwise
     * only the first error message for each attribute will be shown.
     *
     * @return array of the validation errors
     */
    private function collectErrors(bool $encode, bool $showAllErrors): array
    {
        $new = clone $this;

        $lines = [];

        foreach ([$new->data] as $form) {
            $lines = array_unique(array_merge($lines, $form->errorSummary($showAllErrors)));
        }

        /**
         * If there are the same error messages for different attributes, array_unique will leave gaps between
         * sequential keys. Applying array_values to reorder array keys.
         */
        $lines = array_values($lines);

        if ($encode) {
            foreach ($lines as &$line) {
                $line = Html::encode($line);
            }
        }

        return $lines;
    }
}
