<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use InvalidArgumentException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Html\Html;

final class HtmlForm
{
    /**
     * Returns the value of the specified attribute name or expression.
     *
     * For an attribute expression like `[0]dates[0]`, this method will return the value of `$form->dates[0]`.
     * See {@see getAttributeName()} for more details about attribute expression.
     *
     * If an attribute value an array of such instances, the primary value(s) of the AR instance(s) will be returned
     * instead.
     *
     * @param FormModelInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @return string|array the corresponding attribute value.
     *@throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     */
    public static function getAttributeValue(FormModelInterface $form, string $attribute)
    {
        if (!preg_match(Html::$attributeRegex, $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }

        $attribute = $matches[2];

        return $form->getAttributeValue($attribute);
    }

    /**
     * Generates an appropriate input ID for the specified attribute name or expression.
     *
     * This method converts the result {@see getInputName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @param FormModelInterface $form the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for explanation of
     * attribute expression.
     * @param string $charset default `UTF-8`.
     *
     * @return string the generated input ID.
     *@throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     */
    public static function getInputId(FormModelInterface $form, string $attribute, string $charset = 'UTF-8'): string
    {
        $name = mb_strtolower(static::getInputName($form, $attribute), $charset);

        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
    }

    /**
     * Generates an appropriate input name for the specified attribute name or expression.
     *
     * This method generates a name that can be used as the input name to collect user input for the specified
     * attribute. The name is generated according to the of the form and the given attribute name. For example, if the
     * form name of the `Post` form is `Post`, then the input name generated for the `content` attribute would be
     * `Post[content]`.
     *
     * See {@see getAttributeName()} for explanation of attribute expression.
     *
     * @param FormModelInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @return string the generated input name.
     *@throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     */
    public static function getInputName(FormModelInterface $form, string $attribute): string
    {
        $formName = $form->formName();

        if (!preg_match(Html::$attributeRegex, $attribute, $matches)) {
            throw new \InvalidArgumentException('Attribute name must contain word characters only.');
        }

        [, $prefix, $attribute, $suffix] = $matches;

        if ($formName === '' && $prefix === '') {
            return $attribute . $suffix;
        }

        if ($formName !== '') {
            return $formName . $prefix . "[$attribute]" . $suffix;
        }

        throw new \InvalidArgumentException(get_class($form) . '::formName() cannot be empty for tabular inputs.');
    }
}
