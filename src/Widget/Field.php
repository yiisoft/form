<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Attribute\FieldAttributes;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Attribute\WidgetAttributes;
use Yiisoft\Form\Widget\FieldPart\Error;
use Yiisoft\Form\Widget\FieldPart\Hint;
use Yiisoft\Form\Widget\FieldPart\Label;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;

use function array_key_exists;
use function array_merge;
use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 *
 * @psalm-suppress MissingConstructor
 */
final class Field extends FieldAttributes
{
    private array $parts = [];
    private WidgetAttributes $inputWidget;

    /**
     * Renders a file widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     * Available methods:
     * [
     *     'hiddenAttributes()' => [['id' => 'test-id']],
     *     'uncheckValue()' => ['0'],
     *
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return self the field widget instance.
     */
    public function file(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('file');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = File::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders the whole field.
     *
     * This method will generate the label, input tag and hint tag (if any), and assemble them into HTML according to
     * {@see template}.
     *
     * If (not set), the default methods will be called to generate the label and input tag, and use them as the
     * content.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return string the rendering result.
     */
    protected function run(): string
    {
        $content = '';

        $div = Div::tag();

        if (!empty($this->inputWidget)) {
            $content .= $this->renderInputWidget();
        }

        if ($this->getContainerClass() !== '') {
            $div = $div->class($this->getContainerClass());
        }

        if ($this->getContainerAttributes() !== []) {
            $div = $div->attributes($this->getContainerAttributes());
        }

        return $this->getContainer() ? $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render() : $content;
    }

    private function buildField(): self
    {
        $new = clone $this;

        // Set ariadescribedby.
        if ($new->getAriaDescribedBy() === true && $new->inputWidget instanceof InputAttributes) {
            $new->inputWidget = $new->inputWidget->ariaDescribedBy($this->inputWidget->getInputId() . '-help');
        }

        // Set encode.
        $new->inputWidget = $new->inputWidget->encode($new->getEncode());

        // Set input class.
        $inputClass = $new->getInputClass();

        if ($inputClass !== '') {
            $new->inputWidget = $new->inputWidget->class($inputClass);
        }

        // Set valid class and invalid class.
        $invalidClass = $new->getInvalidClass();
        $validClass = $new->getValidClass();

        if ($invalidClass !== '' && $new->inputWidget->hasError()) {
            $new->inputWidget = $new->inputWidget->class($invalidClass);
        } elseif ($validClass !== '' && $new->inputWidget->isValidated()) {
            $new->inputWidget = $new->inputWidget->class($validClass);
        }

        // Set attributes.
        $new->inputWidget = $new->inputWidget->attributes($this->getAttributes());

        return $new;
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderError(): string
    {
        $errorAttributes = $this->getErrorAttributes();
        $errorClass = $this->getErrorClass();

        if ($errorClass !== '') {
            Html::addCssClass($errorAttributes, $errorClass);
        }

        return Error::widget()
            ->attributes($errorAttributes)
            ->encode($this->getEncode())
            ->for($this->inputWidget->getFormModel(), $this->inputWidget->getAttribute())
            ->message($this->getError() ?? '')
            ->messageCallback($this->getErrorMessageCallback())
            ->tag($this->getErrorTag())
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderInputWidget(): string
    {
        $new = clone $this;

        $new = $new->buildField();

        if (!array_key_exists('{input}', $new->parts)) {
            $new->parts['{input}'] = $new->inputWidget->render();
        }

        if (!array_key_exists('{error}', $new->parts)) {
            $new->parts['{error}'] = $this->getError() !== null ? $new->renderError() : '';
        }

        if (!array_key_exists('{hint}', $new->parts)) {
            $new->parts['{hint}'] = $new->renderHint();
        }

        if (!array_key_exists('{label}', $new->parts)) {
            $new->parts['{label}'] = $new->renderLabel();
        }

        if ($new->getDefaultTokens() !== []) {
            $new->parts = array_merge($new->parts, $new->getDefaultTokens());
        }

        return preg_replace('/^\h*\v+/m', '', trim(strtr($new->getTemplate(), $new->parts)));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderHint(): string
    {
        $hintAttributes = $this->getHintAttributes();
        $hintClass = $this->getHintClass();

        if ($hintClass !== '') {
            Html::addCssClass($hintAttributes, $hintClass);
        }

        if ($this->getAriaDescribedBy() === true) {
            $hintAttributes['id'] = $this->inputWidget->getInputId() . '-help';
        }

        return Hint::widget()
            ->attributes($hintAttributes)
            ->encode($this->getEncode())
            ->for($this->inputWidget->getFormModel(), $this->inputWidget->getAttribute())
            ->hint($this->getHint())
            ->tag($this->getHintTag())
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderLabel(): string
    {
        $labelAttributes = $this->getLabelAttributes();
        $labelClass = $this->getLabelClass();

        if (!array_key_exists('for', $labelAttributes)) {
            /** @var string */
            $labelAttributes['for'] = ArrayHelper::getValue(
                $this->getAttributes(),
                'id',
                $this->inputWidget->getInputId(),
            );
        }

        if ($labelClass !== '') {
            Html::addCssClass($labelAttributes, $labelClass);
        }

        return Label::widget()
            ->attributes($labelAttributes)
            ->encode($this->getEncode())
            ->for($this->inputWidget->getFormModel(), $this->inputWidget->getAttribute())
            ->label($this->getLabel())
            ->render();
    }
}
