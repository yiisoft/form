<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;
use Yiisoft\Http\Method;
use Yiisoft\Widget\Widget;

final class FormBuilder extends Widget
{
    use Collection\Options;

    public const VALIDATION_STATE_ON_CONTAINER = 'container';
    public const VALIDATION_STATE_ON_INPUT = 'input';
    private string $action = '';
    private string $method = Method::POST;
    private bool $encodeErrorSummary = true;
    private string $errorCssClass = 'has-error';
    private string $errorSummaryCssClass = 'error-summary';
    private string $inputCssClass = 'form-control';
    private string $requiredCssClass = 'required';
    private string $successCssClass = 'has-success';
    private string $validatingCssClass = 'validating';
    private string $validationStateOn = self::VALIDATION_STATE_ON_CONTAINER;
    private ?string $validationUrl = null;
    private bool $validateOnSubmit = true;
    private bool $validateOnChange = true;
    private bool $validateOnBlur = true;
    private bool $validateOnType = false;
    private int $validationDelay = 500;
    private string $ajaxParam = 'ajax';
    private string $ajaxDataType = 'json';
    private bool $scrollToError = true;
    private int $scrollToErrorOffset = 0;
    private array $attributes = [];

    public function start(): self
    {
        ob_start();
        ob_implicit_flush(0);

        return $this;
    }

    public function run(): string
    {
        $content = ob_get_clean();

        $html = Forms::begin()
            ->action($this->action)
            ->method($this->method)
            ->options($this->options)
            ->start();
        $html .= $content;
        $html .= Forms::end();

        return $html;
    }

    /**
     * Generates a summary of the validation errors.
     *
     * If there is no validation error, an empty error summary markup will still be generated, but it will be hidden.
     *
     * @param FormInterface $forms the forms(s) associated with this form.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - `header`: string, the header HTML for the error summary. If not set, a default prompt string will be used.
     * - `footer`: string, the footer HTML for the error summary.
     *
     * The rest of the options will be rendered as the attributes of the container tag. The values will be HTML-encoded
     * using {@see \Yiisoft\Html\Html::encode()}. If a value is `null`, the corresponding attribute will not be
     * rendered.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated error summary.
     *
     * {@see errorSummaryCssClass}
     */
    public function errorSummary(FormInterface $forms, array $options = []): string
    {
        Html::addCssClass($options, $this->errorSummaryCssClass);

        $options['encode'] = $this->encodeErrorSummary;

        return ErrorSummary::widget()->form($forms)->options($options)->run();
    }

    public function getErrorCssClass(): string
    {
        return $this->errorCssClass;
    }

    public function getInputCssClass(): string
    {
        return $this->inputCssClass;
    }

    public function getRequiredCssClass(): string
    {
        return $this->requiredCssClass;
    }

    public function getValidationStateOn(): string
    {
        return $this->validationStateOn;
    }

    /**
     * Method for specifying the HTTP method for this form.
     *
     * @param string $value the form action URL.
     *
     * @return self
     */
    public function action(string $value): self
    {
        $this->action = $value;

        return $this;
    }

    /**
     * @param string $value the form submission method. This should be either `post` or `get`. Defaults to `post`.
     *
     * When you set this to `get` you may see the url parameters repeated on each request. This is because the default
     * value of {@see action} is set to be the current request url and each submit will add new parameters instead of
     * replacing existing ones.
     *
     * You may set {@see action} explicitly to avoid this:
     *
     * ```php
     * use Yiisoft\Http\Method;
     *
     * $form = FormBuilder::begin()->action('controller/action')->method(Method::GET)->start();
     * ```
     *
     * @return self
     */
    public function method(string $value): self
    {
        $this->method = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform encoding on the error summary.
     *
     * @return self
     */
    public function encodeErrorSummary(bool $value): self
    {
        $this->encodeErrorSummary = $value;

        return $this;
    }

    /**
     * @param string $value the default CSS class for the error summary container.
     *
     * @return self
     */
    public function errorSummaryCssClass(string $value): self
    {
        $this->errorSummaryCssClass = $value;

        return $this;
    }

    /**
     * @param string $value the CSS class that is added to a field container when the associated attribute is required.
     *
     * @return self
     */
    public function requiredCssClass(string $value): self
    {
        $this->requiredCssClass = $value;

        return $this;
    }

    /**
     * @param string $value the CSS class that is added to a field container when the associated attribute has
     * validation error.
     *
     * @return self
     */
    public function errorCssClass(string $value): self
    {
        $this->errorCssClass = $value;

        return $this;
    }

    /**
     * @param string $value the CSS class that is added to a field container when the associated attribute is
     * successfully validated.
     *
     * @return self
     */
    public function successCssClass(string $value): self
    {
        $this->successCssClass = $value;

        return $this;
    }

    /**
     * @param string $value the CSS class that is added to a field container when the associated attribute is being
     * validated.
     *
     * @return self
     */
    public function validatingCssClass(string $value): self
    {
        $this->validatingCssClass = $value;

        return $this;
    }

    /**
     * @param string $value where to render validation state class could be either "container" or "input".
     * Default is "container".
     *
     * @return self
     */
    public function validationStateOn(string $value): self
    {
        $this->validationStateOn = $value;

        return $this;
    }

    /**
     * @param bool $value whether to enable client-side data validation.
     *
     * If {@see FieldBuilder::enableClientValidation} is set, its value will take precedence for that input field.
     *
     * @return self
     */
    public function enableClientValidation(bool $value): self
    {
        $this->enableClientValidation = $value;

        return $this;
    }

    /**
     * @param bool $value whether to enable AJAX-based data validation.
     *
     * If {@see FieldBuilder::enableAjaxValidation} is set, its value will take precedence for that input field.
     *
     * @return self
     */
    public function enableAjaxValidation(bool $value): self
    {
        $this->enableAjaxValidation = $value;

        return $this;
    }

    /**
     * @param string $value the URL for performing AJAX-based validation.
     *
     * If this property is not set, it will take the value of the form's action attribute.
     *
     * @return self
     */
    public function validationUrl(string $value): self
    {
        $this->validationUrl = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation when the form is submitted.
     *
     * @return self
     */
    public function validateOnSubmit(bool $value): self
    {
        $this->validateOnSubmit = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation when the value of an input field is changed.
     *
     * If {@see FieldBuilder::validateOnChange} is set, its value will take precedence for that input field.
     *
     * @return self
     */
    public function validateOnChange(bool $value): self
    {
        $this->validateOnChange = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation when an input field loses focus.
     *
     * If {@see FieldBuilder::$validateOnBlur} is set, its value will take precedence for that input field.
     *
     * @return self
     */
    public function validateOnBlur(bool $value): self
    {
        $this->validateOnBlur = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation while the user is typing in an input field.
     *
     * If {@see FieldBuilder::validateOnType} is set, its value will take precedence for that input field.
     *
     * {@see validationDelay}
     *
     * @return self
     */
    public function validateOnType(bool $value): self
    {
        $this->validateOnType = $value;

        return $this;
    }

    /**
     * @param int $value number of milliseconds that the validation should be delayed when the user types in the field
     * and {@see validateOnType} is set `true`.
     *
     * If {@see FieldBuilder::validationDelay} is set, its value will take precedence for that input field.
     *
     * @return self
     */
    public function validationDelay(int $value): self
    {
        $this->validationDelay = $value;

        return $this;
    }

    /**
     * @param string $value the name of the GET parameter indicating the validation request is an AJAX request.
     *
     * @return self
     */
    public function ajaxParam(string $value): self
    {
        $this->ajaxParam = $value;

        return $this;
    }

    /**
     * @param string $value the type of data that you're expecting back from the server.
     *
     * @return self
     */
    public function ajaxDataType(string $value): self
    {
        $this->ajaxDataType = $value;

        return $this;
    }

    /**
     * @param bool $value whether to scroll to the first error after validation.
     *
     * @return self
     */
    public function scrollToError(bool $value): self
    {
        $this->scrollToError = $value;

        return $this;
    }

    /**
     * @param int $value offset in pixels that should be added when scrolling to the first error.
     *
     * @return self
     */
    public function scrollToErrorOffset(int $value): self
    {
        $this->scrollToErrorOffset = $value;

        return $this;
    }

    /**
     * @param array the client validation options for individual attributes. Each element of the array represents the
     * validation options for a particular attribute.
     *
     * @return self
     */
    public function attributes(array $value): self
    {
        $this->attributes = $value;

        return $this;
    }
}
