<?php

declare(strict_types=1);

namespace Yiisoft\Form\YiisoftYiiValidatableForm;

use InvalidArgumentException;
use Yiisoft\Form\Exception\PropertyNotSupportNestedValuesException;
use Yiisoft\Form\Exception\StaticObjectPropertyException;
use Yiisoft\Form\Exception\UndefinedObjectPropertyException;
use Yiisoft\Form\Exception\ValueNotFoundException;
use Yiisoft\Form\Field\Base\InputData\InputDataInterface;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Validator\Helper\RulesNormalizer;

/**
 * @psalm-import-type NormalizedRulesList from RulesNormalizer
 */
final class FormModelInputData implements InputDataInterface
{
    /**
     * @psalm-var NormalizedRulesList|null
     */
    private ?iterable $validationRules = null;

    public function __construct(
        private FormModelInterface $model,
        private string $property,
    ) {
    }

    /**
     * @psalm-return NormalizedRulesList
     */
    public function getValidationRules(): iterable
    {
        if ($this->validationRules === null) {
            $rules = RulesNormalizer::normalize(null, $this->model);
            $this->validationRules = $rules[$this->property] ?? [];
        }
        return $this->validationRules;
    }

    /**
     * Generates an appropriate input name.
     *
     * This method generates a name that can be used as the input name to collect user input. The name is generated
     * according to the form and the property names. For example, if the form name is `Post`
     * then the input name generated for the `content` property would be `Post[content]`.
     *
     * See {@see getPropertyName()} for explanation of attribute expression.
     *
     * @throws InvalidArgumentException If the attribute name contains non-word characters or empty form name for
     * tabular inputs.
     * @return string|null The generated input name.
     */
    public function getName(): ?string
    {
        $data = $this->parseProperty($this->property);
        $formName = $this->model->getFormName();

        if ($formName === '' && $data['prefix'] === '') {
            return $this->property;
        }

        if ($formName !== '') {
            return "$formName{$data['prefix']}[{$data['name']}]{$data['suffix']}";
        }

        throw new InvalidArgumentException('formName() cannot be empty for tabular inputs.');
    }

    /**
     * @throws UndefinedObjectPropertyException
     * @throws StaticObjectPropertyException
     * @throws PropertyNotSupportNestedValuesException
     * @throws ValueNotFoundException
     */
    public function getValue(): mixed
    {
        $parsedName = $this->parseProperty($this->property);
        return $this->model->getAttributeValue($parsedName['name'] . $parsedName['suffix']);
    }

    public function getLabel(): ?string
    {
        return $this->model->getAttributeLabel($this->getPropertyName());
    }

    public function getHint(): ?string
    {
        return $this->model->getAttributeHint($this->getPropertyName());
    }

    public function getPlaceholder(): ?string
    {
        $placeholder = $this->model->getAttributePlaceholder($this->getPropertyName());
        return $placeholder === '' ? null : $placeholder;
    }

    /**
     * Generates an appropriate input ID.
     *
     * This method converts the result {@see getName()} into a valid input ID.
     *
     * For example, if {@see getInputName()} returns `Post[content]`, this method will return `post-content`.
     *
     * @throws InvalidArgumentException If the attribute name contains non-word characters.
     * @return string|null The generated input ID.
     */
    public function getId(): ?string
    {
        $name = $this->getName();
        if ($name === null) {
            return null;
        }

        $name = mb_strtolower($name, 'UTF-8');
        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
    }

    public function isValidated(): bool
    {
        return $this->model->getValidationResult() !== null;
    }

    public function getValidationErrors(): array
    {
        /** @psalm-var list<string> */
        return $this->model
            ->getValidationResult()
            ?->getAttributeErrorMessages($this->getPropertyName())
            ?? [];
    }

    private function getPropertyName(): string
    {
        $property = $this->parseProperty($this->property)['name'];

        if (!$this->model->hasAttribute($property)) {
            throw new InvalidArgumentException('Property "' . $property . '" does not exist.');
        }

        return $property;
    }

    /**
     * This method parses a property expression and returns an associative array containing
     * real property name, prefix and suffix.
     * For example: `['name' => 'content', 'prefix' => '', 'suffix' => '[0]']`
     *
     * A property expression is a property name prefixed and/or suffixed with array indexes. It is mainly used in
     * tabular data input and/or input of array type. Below are some examples:
     *
     * - `[0]content` is used in tabular data input to represent the "content" property for the first model in tabular
     *    input;
     * - `dates[0]` represents the first array element of the "dates" property;
     * - `[0]dates[0]` represents the first array element of the "dates" property for the first model in tabular
     *    input.
     *
     * @param string $property The property name or expression
     *
     * @throws InvalidArgumentException If the property name contains non-word characters.
     * @return string[] The property name, prefix and suffix.
     */
    private function parseProperty(string $property): array
    {
        if (!preg_match('/(^|.*\])([\w\.\+\-_]+)(\[.*|$)/u', $property, $matches)) {
            throw new InvalidArgumentException('Property name must contain word characters only.');
        }
        return [
            'name' => $matches[2],
            'prefix' => $matches[1],
            'suffix' => $matches[3],
        ];
    }
}
