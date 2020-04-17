<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_merge;
use function array_values;
use function array_unique;

final class ErrorSummary extends Widget
{
    /**
     * Generates a summary of the validation errors.
     *
     * @return string the generated error summary
     */
    public function run(): string
    {
        $header = $this->options['header'] ?? '<p>' . 'Please fix the following errors:' . '</p>';
        $footer = ArrayHelper::remove($this->options, 'footer', '');
        $encode = ArrayHelper::remove($this->options, 'encode', true);
        $showAllErrors = ArrayHelper::remove($this->options, 'showAllErrors', false);
        unset($this->options['header']);

        $lines = $this->collectErrors($encode, $showAllErrors);

        if (empty($lines)) {
            /** still render the placeholder for client-side validation use */
            $content = '<ul></ul>';
            $this->options['style'] = isset($this->options['style'])
                ? rtrim($this->options['style'], ';') . '; display:none' : 'display:none';
        } else {
            $content = '<ul><li>' . implode("</li>\n<li>", $lines) . '</li></ul>';
        }

        return Html::tag('div', $header . $content . $footer, $this->options);
    }

    /**
     * Return array of the validation errors.
     *
     * @param $encode boolean, if set to false then the error messages won't be encoded.
     * @param $showAllErrors boolean, if set to true every error message for each attribute will be shown otherwise
     * only the first error message for each attribute will be shown.
     *
     * @return array of the validation errors
     */
    private function collectErrors(bool $encode, bool $showAllErrors): array
    {
        $lines = [];

        foreach ([$this->form] as $form) {
            $lines = array_unique(array_merge($lines, $form->getErrorSummary($showAllErrors)));
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
