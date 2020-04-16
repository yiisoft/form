<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class BooleanInputForm
{
    /**
     * Generates a boolean input.
     *
     * This method is mainly called by {@see CheckboxForm} and {@see RadioForm}.
     *
     * @param string $type the input type. This can be either `radio` or `checkbox`.
     * @param FormInterface $form the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for the format about
     * attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     * @param string $charset default `UTF-8`.
     *
     * @return string the generated input element.
     */
    public static function create(
        string $type,
        FormInterface $form,
        string $attribute,
        array $options = [],
        string $charset = 'UTF-8'
    ): string {
        $name = isset($options['name']) ? $options['name'] : BaseForm::getInputName($form, $attribute);
        $value = BaseForm::getAttributeValue($form, $attribute);
        $value = 1;


        if (!array_key_exists('value', $options)) {
            $options['value'] = '1';
        }

        if (!array_key_exists('uncheck', $options)) {
            $options['uncheck'] = '0';
        } elseif ($options['uncheck'] === false) {
            unset($options['uncheck']);
        }

        if (!array_key_exists('label', $options)) {
            $options['label'] = Html::encode($form->getAttributeLabel(Html::getAttributeName($attribute)));
        } elseif ($options['label'] === false) {
            unset($options['label']);
        }

        $checked = "$value" === "{$options['value']}";

        if (!array_key_exists('id', $options)) {
            $options['id'] = BaseForm::getInputId($form, $attribute, $charset);
        }

        return Html::$type($name, $checked, $options);
    }
}
