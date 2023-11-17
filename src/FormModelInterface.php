<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Exception\PropertyNotSupportNestedValuesException;
use Yiisoft\Form\Exception\StaticObjectPropertyException;
use Yiisoft\Form\Exception\UndefinedArrayElementException;
use Yiisoft\Form\Exception\UndefinedObjectPropertyException;
use Yiisoft\Form\Exception\ValueNotFoundException;
use Yiisoft\Hydrator\Validator\ValidatedInputInterface;

interface FormModelInterface extends ValidatedInputInterface
{
    public function getAttributeHint(string $attribute): string;

    /**
     * Returns the attribute hints.
     *
     * Attribute hints are mainly used for display purpose. For example, given an attribute `isPublic`, we can declare
     * a hint `Whether the post should be visible for not logged-in users`, which provides user-friendly description of
     * the attribute meaning and can be displayed to end users.
     *
     * Unlike label hint will not be generated, if its explicit declaration is omitted.
     *
     * Note, in order to inherit hints defined in the parent class, a child class needs to merge the parent hints with
     * child hints using functions such as `array_merge()`.
     *
     * @return array attribute hints (name => hint)
     *
     * @psalm-return array<string,string>
     */
    public function getAttributeHints(): array;

    /**
     * Returns the text label for the specified attribute.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The attribute label.
     */
    public function getAttributeLabel(string $attribute): string;

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default, an attribute label is generated automatically. This method allows you to
     * explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     *
     * {@see getAttributeLabel()}
     *
     * @psalm-return array<string,string>
     */
    public function getAttributeLabels(): array;

    /**
     * Returns the text placeholder for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute placeholder.
     */
    public function getAttributePlaceholder(string $attribute): string;

    /**
     * @throws UndefinedArrayElementException
     * @throws UndefinedObjectPropertyException
     * @throws StaticObjectPropertyException
     * @throws PropertyNotSupportNestedValuesException
     * @throws ValueNotFoundException
     */
    public function getAttributeValue(string $attribute): mixed;

    /**
     * Returns the attribute placeholders.
     *
     * @return array attribute placeholder (name => placeholder)
     *
     * @psalm-return array<string,string>
     */
    public function getAttributePlaceholders(): array;

    /**
     * Returns the form name that this model class should use.
     *
     * The form name is mainly used by {@see \Yiisoft\Form\Helper\HtmlForm} to determine how to name the input
     * fields for the attributes in a model.
     * If the form name is "A" and an attribute name is "b", then the corresponding input name would be "A[b]".
     * If the form name is an empty string, then the input name would be "b".
     *
     * The purpose of the above naming schema is that for forms which contain multiple different models, the attributes
     * of each model are grouped in sub-arrays of the POST-data, and it is easier to differentiate between them.
     *
     * By default, this method returns the model class name (without the namespace part) as the form name. You may
     * override it when the model is used in different forms.
     *
     * @return string The form name of this model class.
     */
    public function getFormName(): string;

    /**
     * If there is such attribute in the set.
     */
    public function hasAttribute(string $attribute): bool;

    public function isValid(): bool;
}
