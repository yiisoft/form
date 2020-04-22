<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

trait HtmlForm
{
    /**
     * Returns the real attribute name from the given attribute expression.
     *
     * An attribute expression is an attribute name prefixed and/or suffixed with array indexes.
     *
     * It is mainly used in tabular data input and/or input of array type. Below are some examples:
     *
     * - `[0]content` is used in tabular data input to represent the "content" attribute for the first form in tabular
     * input;
     * - `dates[0]` represents the first array element of the "dates" attribute;
     * - `[0]dates[0]` represents the first array element of the "dates" attribute
     * for the first form in tabular input.
     *
     * If `$attribute` has neither prefix nor suffix, it will be returned back without change.
     *
     * @param string $attribute the attribute name or expression.
     *
     * @throws \InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the attribute name without prefix and suffix.
     */
    private function getAttributeName(string $attribute): string
    {
        if (preg_match(Html::$attributeRegex, $attribute, $matches)) {
            return $matches[2];
        }

        throw new \InvalidArgumentException('Attribute name must contain word characters only.');
    }

    /**
     * Returns the value of the specified attribute name or expression.
     *
     * For an attribute expression like `[0]dates[0]`, this method will return the value of `$form->dates[0]`.
     * See {@see getAttributeName()} for more details about attribute expression.
     *
     * If an attribute value an array of such instances, the primary value(s) of the AR instance(s) will be returned
     * instead.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @throws \InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string|array the corresponding attribute value.
     */
    private function getAttributeValue(FormInterface $form, string $attribute)
    {
        if (!preg_match(Html::$attributeRegex, $attribute, $matches)) {
            throw new \InvalidArgumentException('Attribute name must contain word characters only.');
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
     * @param FormInterface $form the form object
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for explanation of
     * attribute expression.
     * @param string $charset default `UTF-8`.
     *
     * @throws \InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the generated input ID.
     */
    private function addInputId(FormInterface $form, string $attribute, string $charset = 'UTF-8'): string
    {
        $name = mb_strtolower($this->getInputName($form, $attribute), $charset);

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
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @throws \InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the generated input name.
     */
    private function getInputName(FormInterface $form, string $attribute): string
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

    /**
     * Generate placeholder from form attribute label.
     *
     * @param FormInterface $form the form object.
     * @param string $attribute the attribute name or expression. See {@see getAttributeName()} for the format about
     * attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see encode()}.
     */
    private function addPlaceholders(FormInterface $form, string $attribute, &$options = []): void
    {
        if (isset($options['placeholder']) && $options['placeholder'] === true) {
            $attribute = $this->getAttributeName($attribute);
            $this->options['placeholder'] = $form->attributeLabel($attribute);
        }
    }
}
