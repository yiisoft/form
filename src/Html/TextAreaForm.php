<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class TextAreaForm
{
    /**
     * Generates a textarea tag for the given form attribute.
     *
     * The form attribute value will be used as the content in the textarea.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see BaseForm::getAttributeName()} for the
     * format about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * The following special options are recognized:
     *
     * - placeholder: string|boolean, when `placeholder` equals `true`, the attribute label from the $form will be used
     * as a placeholder.
     *
     * @return string the generated textarea tag.
     */
    public static function create(FormInterface $form, string $attribute, array $options = []): string
    {
        $name = isset($options['name']) ? $options['name'] : BaseForm::getInputName($form, $attribute);

        if (isset($options['value'])) {
            $value = $options['value'];
            unset($options['value']);
        } else {
            $value = BaseForm::getAttributeValue($form, $attribute);
        }

        if (!array_key_exists('id', $options)) {
            $options['id'] = BaseForm::getInputId($form, $attribute);
        }

        BaseForm::placeHolder($form, $attribute, $options);

        return Html::textarea($name, $value, $options);
    }
}
