<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class ErrorSummaryForm
{
    /**
     * Generates a summary of the validation errors.
     *
     * If there is no validation error, an empty error summary markup will still be generated, but it will be hidden.
     * @param FormInterface $form the form(s) whose validation errors are to be displayed.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - header: string, the header HTML for the error summary. If not set, a default prompt string will be used.
     * - footer: string, the footer HTML for the error summary. Defaults to empty string.
     * - encode: boolean, if set to false then the error messages won't be encoded. Defaults to `true`.
     * - showAllErrors: boolean, if set to true every error message for each attribute will be shown otherwise only the
     * first error message for each attribute will be shown. Defaults to `false`.
     *
     * The rest of the options will be rendered as the attributes of the container tag.
     *
     * @return string the generated error summary
     */
    public static function create(FormInterface $form, array $options = []): string
    {
        $header = isset($options['header']) ? $options['header'] : '<p>' . 'Please fix the following errors:' . '</p>';
        $footer = ArrayHelper::remove($options, 'footer', '');
        $encode = ArrayHelper::remove($options, 'encode', true);
        $showAllErrors = ArrayHelper::remove($options, 'showAllErrors', false);
        unset($options['header']);

        $lines = self::collectErrors($form, $encode, $showAllErrors);

        if (empty($lines)) {
            // still render the placeholder for client-side validation use
            $content = '<ul></ul>';
            $options['style'] = isset($options['style']) ? rtrim($options['style'], ';') . '; display:none' : 'display:none';
        } else {
            $content = '<ul><li>' . implode("</li>\n<li>", $lines) . '</li></ul>';
        }

        return Html::tag('div', $header . $content . $footer, $options);
    }

    /**
     * Return array of the validation errors.
     *
     * @param FormInterface $form the form(s) whose validation errors are to be displayed.
     * @param $encode boolean, if set to false then the error messages won't be encoded.
     * @param $showAllErrors boolean, if set to true every error message for each attribute will be shown otherwise
     * only the first error message for each attribute will be shown.
     *
     * @return array of the validation errors
     */
    private static function collectErrors(FormInterface $forms, bool $encode, bool $showAllErrors): array
    {
        $lines = [];

        if (!\is_array($forms)) {
            $forms = [$forms];
        }

        foreach ($forms as $form) {
            $lines = \array_unique(\array_merge($lines, $form->getErrorSummary($showAllErrors)));
        }

        /**
         * If there are the same error messages for different attributes, array_unique will leave gaps between
         * sequential keys. Applying array_values to reorder array keys.
         */
        $lines = \array_values($lines);

        if ($encode) {
            foreach ($lines as &$line) {
                $line = Html::encode($line);
            }
        }

        return $lines;
    }
}
