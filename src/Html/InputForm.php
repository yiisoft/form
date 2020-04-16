<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class InputForm
{
    /**
     * Generates an input tag for the given form attribute.
     *
     * This method will generate the "name" and "value" tag attributes automatically for the form attribute unless
     * they are explicitly specified in `$options`.
     *
     * @param string $type the input type (e.g. 'text', 'password').
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for the format about
     * attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see encode()}.
     * @return string the generated input tag
     * @param string $charset default `UTF-8`.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public static function create(
        string $type,
        FormInterface $form,
        string $attribute,
        array $options = [],
        string $charset = 'UTF-8'
    ): string {
        $name = isset($options['name']) ? $options['name'] : BaseForm::getInputName($form, $attribute);
        $value = isset($options['value']) ? $options['value'] : BaseForm::getAttributeValue($form, $attribute);

        if (!array_key_exists('id', $options)) {
            $options['id'] = BaseForm::getInputId($form, $attribute, $charset);
        }

        BaseForm::placeHolder($form, $attribute, $options);

        return Html::input($type, $name, $value, $options);
    }
}
