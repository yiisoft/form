<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Form\FormInterface;

final class PasswordInputForm
{
    /**
     * Generates a password input tag for the given form attribute.
     *
     * This method will generate the "name" and "value" tag attributes automatically for the form attribute unless
     * they are explicitly specified in `$options`.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. {@see BaseForm::getAttributeName()} for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * The following special options are recognized:
     *
     * - placeholder: string|boolean, when `placeholder` equals `true`, the attribute label from the $form will be used
     * as a placeholder.
     *
     * @return string the generated input tag,
     */
    public static function create(FormInterface $form, string $attribute, array $options = []): string
    {
        return InputForm::create('password', $form, $attribute, $options);
    }
}
