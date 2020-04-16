<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Form\FormInterface;

final class CheckBoxForm
{
    /**
     * Generates a checkbox tag together with a label for the given model attribute.
     *
     * This method will generate the "checked" tag attribute according to the model attribute value.
     *
     * @param FormInterface $model the model object.
     * @param string $attribute the attribute name or expression. See {@see \Yiisoft\Html\Html::getAttributeName()} for
     * the format about attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     *
     * @return string the generated checkbox tag.
     *
     * {@see \Yiisoft\Form\Html\BaseForm::booleanInput()} for details about accepted attributes.
     */
    public static function create(FormInterface $model, string $attribute, array $options = []): string
    {
        return BooleanInputForm::create('checkbox', $model, $attribute, $options);
    }
}
