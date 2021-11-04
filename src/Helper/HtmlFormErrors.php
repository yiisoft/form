<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use Yiisoft\Form\FormModelInterface;

/**
 * HtmlFormErrors renders a list of errors for the specified model attribute.
 */
final class HtmlFormErrors
{
    /**
     * Returns the errors for single attribute.
     *
     * @param FormModelInterface $formModel the form object.
     * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
     */
    public static function getError(FormModelInterface $formModel, string $attribute): array
    {
        return $formModel->getFormErrors()->getError($attribute);
    }

    /**
     * Returns the errors for all attributes.
     *
     * @param FormModelInterface $formModel the form object.
     *
     * @return array the error messages.
     */
    public static function getErrors(FormModelInterface $formModel): array
    {
        return $formModel->getFormErrors()->getErrors();
    }

    /**
     * Returns the errors for all attributes as a one-dimensional array.
     *
     * @param FormModelInterface $formModel the form object.
     * @param bool $showAllErrors boolean, if set to true every error message for each attribute will be shown otherwise
     * only the first error message for each attribute will be shown.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     */
    public static function getErrorSummary(FormModelInterface $formModel, bool $showAllErrors): array
    {
        return $formModel->getFormErrors()->getErrorSummary($showAllErrors);
    }

    /**
     * Return the attribute first error message.
     *
     * @param FormModelInterface $formModel the form object.
     * @param string $attribute the attribute name or expression.
     *
     * @return string the error message. Empty string returned if there is no error.
     */
    public static function getFirstError(FormModelInterface $formModel, string $attribute): string
    {
        return $formModel->getFormErrors()->getFirstError(HtmlForm::getAttributeName($formModel, $attribute));
    }

    /**
     * Returns a value indicating whether there is any validation error.
     *
     * @param FormModelInterface $formModel the form object.
     * @param string|null $attribute attribute name. Use null to check all attributes.
     *
     * @return bool whether there is any error.
     */
    public static function hasErrors(FormModelInterface $formModel, ?string $attribute = null): bool
    {
        return $formModel->getFormErrors()->hasErrors($attribute);
    }
}
