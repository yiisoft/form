<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;

final class FileInputForm
{
    /**
     * Generates a file input tag for the given form attribute.
     *
     * This method will generate the "name" and "value" tag attributes automatically for the form attribute unless
     * they are explicitly specified in `$options`.
     *
     * Additionally, if a separate set of HTML options array is defined inside `$options` with a key named
     * `hiddenOptions`, it will be passed to the `HiddenInput` field as its own `$options` parameter.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see BaseForm::getAttributeName()} for the
     * format about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     * If `hiddenOptions` parameter which is another set of HTML options array is defined, it will be extracted from
     * `$options` to be used for the hidden input.
     *
     * @return string the generated input tag.
     */
    public static function create(FormInterface $form, string $attribute, array $options = []): string
    {
        $hiddenOptions = ['id' => null, 'value' => ''];

        if (isset($options['name'])) {
            $hiddenOptions['name'] = $options['name'];
        }

        /** make sure disabled input is not sending any value */
        if (!empty($options['disabled'])) {
            $hiddenOptions['disabled'] = $options['disabled'];
        }

        $hiddenOptions = ArrayHelper::merge($hiddenOptions, ArrayHelper::remove($options, 'hiddenOptions', []));

        /**
         * Add a hidden field so that if a form only has a file field, we can still use isset($body[$formClass]) to
         * detect if the input is submitted.
         * The hidden input will be assigned its own set of html options via `$hiddenOptions`.
         * This provides the possibility to interact with the hidden field via client script.
         *
         * Note: For file-field-only form with `disabled` option set to `true` input submitting detection won't work.
         */
        return HiddenInputForm::create($form, $attribute, $hiddenOptions)
            . InputForm::create('file', $form, $attribute, $options);
    }
}
