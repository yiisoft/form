<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;
use Yiisoft\Http\Method;
use Yiisoft\Widget\Widget;

final class FormBuilder extends Widget
{
    public const VALIDATION_STATE_ON_CONTAINER = 'container';
    public const VALIDATION_STATE_ON_INPUT = 'input';
    private string $id;
    private string $action = '';
    private string $method = Method::POST;
    private array $options = [];
    private array $fieldOptions = [
        'errorCss()' => ['has-error'],
        'errorSummaryCss()' => ['error-summary'],
        'inputCss()' => ['form-control'],
        'requiredCss()' => ['required'],
        'succesCss()' => ['has-success'],
        'validatingCss()' => ['validating'],
        'validationStateOn()' => [self::VALIDATION_STATE_ON_INPUT],
    ];
    private array $listOptions = [
        'accept-charset',
        'action',
        'autocomplete',
        'class',
        'csrf',
        'enctype',
        'method',
        'name',
        'novalidate',
        'target'
    ];

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

    public function field(FormInterface $form, string $attribute, array $options = [])
    {
        return FieldBuilder::widget($this->fieldOptions)
            ->data($form)
            ->attribute($attribute)
            ->options($options);
    }

    public function id(string $value): self
    {
        $this->id = $value;

        return $this;
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
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }
}
