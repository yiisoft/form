<?php

declare(strict_types=1);

namespace Yiisoft\Form\Html;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

final class LabelForm
{
    /**
     * Generates a label tag for the given form attribute.
     *
     * The label text is the label associated with the attribute, obtained via {@see Form::getAttributeLabel()}.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see BaseForm::getAttributeName()} for the
     * format about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     * @param string $charset default `UTF-8`.
     *
     * If a value is null, the corresponding attribute will not be rendered.
     *
     * The following options are specially handled:
     *
     * - label: this specifies the label to be displayed. Note that this will NOT be
     * {@see \Yiisoft\Html\Htmlencode()|encoded}.
     *
     * If this is not set, {@see Model::getAttributeLabel()} will be called to get the label for display (after
     * encoding).
     *
     * See {@see renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return string the generated label tag.
     */
    public static function create(
        FormInterface $form,
        string $attribute,
        array $options = [],
        string $charset = 'UTF-8'
    ): string {
        $for = ArrayHelper::remove($options, 'for', BaseForm::getInputId($form, $attribute, $charset));
        $attribute = BaseForm::getAttributeName($attribute);

        $label = ArrayHelper::remove($options, 'label', Html::encode($form->getAttributeLabel($attribute)));

        return Html::label($label, $for, $options);
    }
}
