<?php

declare(strict_types=1);

namespace Yiisoft\Form\YiisoftFormModel;

use Yiisoft\Form\YiisoftFormModel\Exception\PropertyNotSupportNestedValuesException;
use Yiisoft\Form\YiisoftFormModel\Exception\StaticObjectPropertyException;
use Yiisoft\Form\YiisoftFormModel\Exception\UndefinedObjectPropertyException;
use Yiisoft\Form\YiisoftFormModel\Exception\ValueNotFoundException;
use Yiisoft\Hydrator\Validator\ValidatedInputInterface;

interface FormModelInterface extends ValidatedInputInterface
{
    public function getPropertyHint(string $property): string;

    /**
     * Returns the property hints.
     *
     * Property hints are mainly used for display purpose. For example, given a property `isPublic`, we can declare
     * a hint `Whether the post should be visible for not logged-in users`, which provides user-friendly description of
     * the property meaning and can be displayed to end users.
     *
     * Unlike label hint will not be generated, if its explicit declaration is omitted.
     *
     * Note, in order to inherit hints defined in the parent class, a child class needs to merge the parent hints with
     * child hints using functions such as `array_merge()`.
     *
     * @return array Property hints (name => hint)
     *
     * @psalm-return array<string,string>
     */
    public function getPropertyHints(): array;

    /**
     * Returns the text label for the specified property.
     *
     * @param string $property The property name.
     *
     * @return string The property label.
     */
    public function getPropertyLabel(string $property): string;

    /**
     * Returns the property labels.
     *
     * Property labels are mainly used for display purpose. For example, given a property `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default, a property label is generated automatically. This method allows you to
     * explicitly specify property labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array Property labels (name => label)
     *
     * {@see getPropertyLabel()}
     *
     * @psalm-return array<string,string>
     */
    public function getPropertyLabels(): array;

    /**
     * Returns the text placeholder for the specified property.
     *
     * @param string $property The property name.
     *
     * @return string The property placeholder.
     */
    public function getPropertyPlaceholder(string $property): string;

    /**
     * @throws UndefinedObjectPropertyException
     * @throws StaticObjectPropertyException
     * @throws PropertyNotSupportNestedValuesException
     * @throws ValueNotFoundException
     */
    public function getPropertyValue(string $property): mixed;

    /**
     * Returns the property placeholders.
     *
     * @return array Property placeholder (name => placeholder)
     *
     * @psalm-return array<string,string>
     */
    public function getPropertyPlaceholders(): array;

    /**
     * Returns the form name that this model class should use.
     *
     * The form name is mainly used by {@see \Yiisoft\Form\InputData\HtmlForm} to determine how to name the input
     * fields for the properties in a model.
     * If the form name is "A" and a property name is "b", then the corresponding input name would be "A[b]".
     * If the form name is an empty string, then the input name would be "b".
     *
     * The purpose of the above naming schema is that for forms which contain multiple different models, the properties
     * of each model are grouped in sub-arrays of the POST-data, and it is easier to differentiate between them.
     *
     * By default, this method returns the model class name (without the namespace part) as the form name. You may
     * override it when the model is used in different forms.
     *
     * @return string The form name of this model class.
     */
    public function getFormName(): string;

    /**
     * If there is such property in the set.
     */
    public function hasProperty(string $property): bool;

    public function isValid(): bool;
}
