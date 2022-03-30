<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Http\Method;
use Yiisoft\Widget\Widget;

use function explode;
use function implode;
use function strpos;
use function strtoupper;
use function substr;
use function urldecode;

/**
 *  Generates a form start tag.
 *
 *  @link https://www.w3.org/TR/html52/sec-forms.html
 */
final class Form extends Widget
{
    private string $action = '';
    private array $attributes = [];
    private string $csrfName = '';
    private string $csrfToken = '';
    private string $method = Method::POST;

    /**
     * @return string the generated form start tag.
     *
     * {@see end())}
     */
    public function begin(): string
    {
        parent::begin();

        $attributes = $this->attributes;
        $action = $this->action;
        $hiddenInputs = [];

        if ($this->csrfToken !== '' && $this->method === Method::POST) {
            $hiddenInputs[] = Html::hiddenInput($this->csrfName, $this->csrfToken);
        }

        if ($this->method === Method::GET && ($pos = strpos($action, '?')) !== false) {
            /**
             * Query parameters in the action are ignored for GET method we use hidden fields to add them back.
             */
            foreach (explode('&', substr($action, $pos + 1)) as $pair) {
                if (($pos1 = strpos($pair, '=')) !== false) {
                    $hiddenInputs[] = Html::hiddenInput(
                        urldecode(substr($pair, 0, $pos1)),
                        urldecode(substr($pair, $pos1 + 1))
                    );
                } else {
                    $hiddenInputs[] = Html::hiddenInput(urldecode($pair), '');
                }
            }

            $action = substr($action, 0, $pos);
        }

        if ($action !== '') {
            $attributes['action'] = $action;
        }

        $attributes['method'] = $this->method;

        if ($this->csrfToken !== '') {
            /** @var string */
            $attributes[$this->csrfName] = $this->csrfToken;
        }

        $form = Html::openTag('form', $attributes);

        if (!empty($hiddenInputs)) {
            $form .= PHP_EOL . implode(PHP_EOL, $hiddenInputs);
        }

        return $form;
    }

    /**
     * The accept-charset content attribute gives the character encodings that are to be used for the submission.
     * If specified, the value must be an ordered set of unique space-separated tokens that are ASCII case-insensitive,
     * and each token must be an ASCII case-insensitive match for one of the labels of an ASCII-compatible encoding.
     *
     * @param string $value the accept-charset attribute value.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-accept-charset
     */
    public function acceptCharset(string $value): self
    {
        $new = clone $this;
        $new->attributes['accept-charset'] = $value;
        return $new;
    }

    /**
     * The action and formation content attributes, if specified, must have a value that is a valid non-empty URL
     * potentially surrounded by spaces.
     *
     * @param string $value the action attribute value.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-action
     */
    public function action(string $value): self
    {
        $new = clone $this;
        $new->action = $value;
        return $new;
    }

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * Specifies whether the element represents an input control for which a UA is meant to store the value entered by
     * the user (so that the UA can prefill the form later).
     *
     * @param bool $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-autocompleteelements-autocomplete
     */
    public function autocomplete(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['autocomplete'] = $value ? 'on' : 'off';
        return $new;
    }

    /**
     * The CSRF-token content attribute token that are known to be safe to use for.
     *
     * @param string|Stringable $csrfToken the CSRF-token attribute value.
     * @param string $csrfName the CSRF-token attribute name.
     *
     * @return self
     */
    public function csrf(string|Stringable $csrfToken, string $csrfName = '_csrf'): self
    {
        $new = clone $this;
        $new->csrfToken = $csrfToken instanceof Stringable ? $csrfToken->__toString() : $csrfToken;
        $new->csrfName = $csrfName;
        return $new;
    }

    /**
     * Set CSS class of the field widget.
     *
     * @param string $class
     *
     * @return self
     */
    public function class(string $class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * The form-enctype content attribute specifies the content type of the form submission.
     *
     * @param string $value the form-enctype attribute value.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-enctype
     */
    public function enctype(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    /**
     * Set the ID of the widget.
     *
     * @param string|null $id
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * The method content attribute specifies how the form-data should be submitted.
     *
     * @param string $value the method attribute value.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-method
     */
    public function method(string $value): self
    {
        $new = clone $this;
        $new->method = strtoupper($value);
        return $new;
    }

    /**
     * The novalidate and form-novalidate content attributes are boolean attributes. If present, they indicate that the
     * form is not to be validated during submission.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-novalidate
     */
    public function noHtmlValidation(): self
    {
        $new = clone $this;
        $new->attributes['novalidate'] = true;
        return $new;
    }

    /**
     * The target and form-target content attributes, if specified, must have values that are valid browsing context
     * names or keywords.
     *
     * @param string $value the target attribute value, for default its `_blank`.
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-form-target
     */
    public function target(string $value): self
    {
        $new = clone $this;
        $new->attributes['target'] = $value;
        return $new;
    }

    /**
     * Generates a form end tag.
     *
     * @return string the generated tag.
     *
     * {@see beginForm()}
     */
    protected function run(): string
    {
        return Html::closeTag('form');
    }
}
