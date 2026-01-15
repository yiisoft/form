<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Html\Html;

use function in_array;
use function is_array;
use function is_string;

abstract class PartsField extends BaseField
{
    /**
     * @psalm-suppress MissingClassConstType
     */
    private const BUILTIN_TOKENS = [
        '{input}',
        '{label}',
        '{hint}',
        '{error}',
    ];

    protected string $templateBegin = "{label}\n{input}";
    protected string $templateEnd = "{input}\n{hint}\n{error}";
    protected string $template = "{label}\n{input}\n{hint}\n{error}";
    protected ?string $label = null;
    protected ?bool $hideLabel = null;

    /**
     * @psalm-var non-empty-string|null
     */
    protected ?string $inputContainerTag = null;
    protected array $inputContainerAttributes = [];

    protected string|Stringable $beforeInput = '';
    protected string|Stringable $afterInput = '';

    /**
     * @var string[]|Stringable[]
     * @psalm-var array<non-empty-string,string|Stringable>
     */
    private array $extraTokens = [];

    private bool $replaceLabelAttributes = false;
    private bool $replaceLabelClass = false;
    private array $labelAttributes = [];
    private array $labelConfig = [];

    private bool $replaceHintAttributes = false;
    private bool $replaceHintClass = false;
    private array $hintAttributes = [];
    private array $hintConfig = [];

    private bool $replaceErrorAttributes = false;
    private bool $replaceErrorClass = false;
    private array $errorAttributes = [];
    private array $errorConfig = [];

    final public function tokens(array $tokens): static
    {
        $new = clone $this;

        foreach ($tokens as $token => $value) {
            if (!is_string($token)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Token should be string. %s given.',
                        get_debug_type($token),
                    ),
                );
            }

            if (!is_string($value) && !$value instanceof Stringable) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Token value should be string or Stringable. %s given.',
                        get_debug_type($value),
                    ),
                );
            }

            $this->validateToken($token);

            $new->extraTokens[$token] = $value;
        }

        return $new;
    }

    final public function token(string $token, string|Stringable $value): static
    {
        $this->validateToken($token);

        $new = clone $this;
        $new->extraTokens[$token] = $value;
        return $new;
    }

    /**
     * Set layout template for render a field.
     */
    final public function template(string $template): static
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    final public function templateBegin(string $template): static
    {
        $new = clone $this;
        $new->templateBegin = $template;
        return $new;
    }

    final public function templateEnd(string $template): static
    {
        $new = clone $this;
        $new->templateEnd = $template;
        return $new;
    }

    final public function hideLabel(?bool $hide = true): static
    {
        $new = clone $this;
        $new->hideLabel = $hide;
        return $new;
    }

    final public function inputContainerTag(?string $tag): static
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->inputContainerTag = $tag;
        return $new;
    }

    final public function inputContainerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->inputContainerAttributes = $attributes;
        return $new;
    }

    final public function addInputContainerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->inputContainerAttributes = array_merge($new->inputContainerAttributes, $attributes);
        return $new;
    }

    /**
     * Replace input container tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function inputContainerClass(?string ...$class): static
    {
        $new = clone $this;
        $new->inputContainerAttributes['class'] = array_filter($class, static fn($c) => $c !== null);
        return $new;
    }

    /**
     * Add one or more CSS classes to the input container tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function addInputContainerClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass($new->inputContainerAttributes, $class);
        return $new;
    }

    final public function beforeInput(string|Stringable $content): static
    {
        $new = clone $this;
        $new->beforeInput = $content;
        return $new;
    }

    final public function afterInput(string|Stringable $content): static
    {
        $new = clone $this;
        $new->afterInput = $content;
        return $new;
    }

    final public function labelConfig(array $config): static
    {
        $new = clone $this;
        $new->labelConfig = $config;
        return $new;
    }

    final public function labelAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->labelAttributes = $attributes;
        $new->replaceLabelAttributes = true;
        return $new;
    }

    final public function addLabelAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->labelAttributes = array_merge($new->labelAttributes, $attributes);
        return $new;
    }

    /**
     * Set label tag ID.
     *
     * @param string|null $id Label tag ID.
     */
    final public function labelId(?string $id): static
    {
        $new = clone $this;
        $new->labelAttributes['id'] = $id;
        return $new;
    }

    /**
     * Replace label tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function labelClass(?string ...$class): static
    {
        $new = clone $this;
        $new->labelAttributes['class'] = $class;
        $new->replaceLabelClass = true;
        return $new;
    }

    /**
     * Add one or more CSS classes to the label tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function addLabelClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass($new->labelAttributes, $class);
        return $new;
    }

    final public function label(?string $content): static
    {
        $new = clone $this;
        $new->label = $content;
        return $new;
    }

    final public function hintConfig(array $config): static
    {
        $new = clone $this;
        $new->hintConfig = $config;
        return $new;
    }

    final public function hintAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->hintAttributes = $attributes;
        $new->replaceHintAttributes = true;
        return $new;
    }

    final public function addHintAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->hintAttributes = array_merge($new->hintAttributes, $attributes);
        return $new;
    }

    /**
     * Set hint tag ID.
     *
     * @param string|null $id Hint tag ID.
     */
    final public function hintId(?string $id): static
    {
        $new = clone $this;
        $new->hintAttributes['id'] = $id;
        return $new;
    }

    /**
     * Replace hint tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function hintClass(?string ...$class): static
    {
        $new = clone $this;
        $new->hintAttributes['class'] = $class;
        $new->replaceHintClass = true;
        return $new;
    }

    /**
     * Add one or more CSS classes to the hint tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function addHintClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass($new->hintAttributes, $class);
        return $new;
    }

    final public function hint(?string $content): static
    {
        $new = clone $this;
        $new->hintConfig['content()'] = [$content];
        return $new;
    }

    final public function errorConfig(array $config): static
    {
        $new = clone $this;
        $new->errorConfig = $config;
        return $new;
    }

    final public function errorAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->errorAttributes = $attributes;
        $new->replaceErrorAttributes = true;
        return $new;
    }

    final public function addErrorAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->errorAttributes = array_merge($new->errorAttributes, $attributes);
        return $new;
    }

    /**
     * Set error tag ID.
     *
     * @param string|null $id Error tag ID.
     */
    final public function errorId(?string $id): static
    {
        $new = clone $this;
        $new->errorAttributes['id'] = $id;
        return $new;
    }

    /**
     * Replace error tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function errorClass(?string ...$class): static
    {
        $new = clone $this;
        $new->errorAttributes['class'] = $class;
        $new->replaceErrorClass = true;
        return $new;
    }

    /**
     * Add one or more CSS classes to the error tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function addErrorClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass($new->errorAttributes, $class);
        return $new;
    }

    final public function error(?string $message, string ...$messages): static
    {
        $new = clone $this;
        $new->errorConfig['message()'] = [$message, ...$messages];
        return $new;
    }

    protected function shouldHideLabel(): bool
    {
        return false;
    }

    protected function generateInput(): string
    {
        return '';
    }

    protected function generateBeginInput(): string
    {
        return '';
    }

    protected function generateEndInput(): string
    {
        return '';
    }

    protected function renderLabel(Label $label): string
    {
        return $label->render();
    }

    protected function renderHint(Hint $hint): string
    {
        return $hint->render();
    }

    protected function renderError(Error $error): string
    {
        return $error->render();
    }

    final protected function generateContent(): ?string
    {
        $parts = [
            '{input}' => $this->generateInputContainerBegin()
                . $this->beforeInput
                . $this->generateInput()
                . $this->afterInput
                . $this->generateInputContainerEnd(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return $this->makeContent($this->template, $parts);
    }

    final protected function generateBeginContent(): string
    {
        $parts = [
            '{input}' => $this->generateBeginInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return $this->makeContent($this->templateBegin, $parts);
    }

    final protected function generateEndContent(): string
    {
        $parts = [
            '{input}' => $this->generateEndInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return $this->makeContent($this->templateEnd, $parts);
    }

    final protected function hasCustomError(): bool
    {
        return isset($this->errorConfig['message()']);
    }

    private function generateInputContainerBegin(): string
    {
        return $this->inputContainerTag === null
            ? ''
            : Html::tag($this->inputContainerTag, '', $this->inputContainerAttributes)->open();
    }

    private function generateInputContainerEnd(): string
    {
        return $this->inputContainerTag === null ? '' : ('</' . $this->inputContainerTag . '>');
    }

    /**
     * @psalm-param array<non-empty-string, string> $parts
     */
    private function makeContent(string $template, array $parts): string
    {
        if (!empty($this->extraTokens)) {
            $parts += $this->extraTokens;
        }

        $emptyParts = [];
        $nonEmptyParts = [];
        foreach ($parts as $key => $value) {
            $value = trim((string) $value);
            if ($value === '') {
                $emptyParts[$key] = '';
                continue;
            }
            $nonEmptyParts[$key] = $value;
        }

        /**
         * @var string $result We use correct regular expression, so `preg_replace` will return string.
         */
        $result = preg_replace('/^\h*\v+/m', '', trim(strtr($template, $emptyParts)));

        return strtr($result, $nonEmptyParts);
    }

    private function generateLabel(): string
    {
        $labelConfig = $this->labelConfig;
        if ($this->label !== null) {
            $labelConfig['content()'] = [$this->label];
        }

        $label = Label::widget([], $labelConfig);

        $labelAttributes = $this->labelAttributes;
        if (!empty($labelAttributes)) {
            if ($this->replaceLabelAttributes) {
                $label = $label->attributes($labelAttributes);
            } else {
                /** @psalm-var array<array-key,string|null>|string|null $class */
                $class = $this->labelAttributes['class'] ?? null;
                unset($labelAttributes['class']);

                $label = $label->addAttributes($labelAttributes);

                if ($this->replaceLabelClass) {
                    $label = is_array($class) ? $label->class(...$class) : $label->class($class);
                } elseif ($class !== null) {
                    $label = is_array($class) ? $label->addClass(...$class) : $label->addClass($class);
                }
            }
        }

        return $this->renderLabel($label);
    }

    private function generateHint(): string
    {
        $hint = Hint::widget([], $this->hintConfig);

        $hintAttributes = $this->hintAttributes;
        if (!empty($hintAttributes)) {
            if ($this->replaceHintAttributes) {
                $hint = $hint->attributes($hintAttributes);
            } else {
                /** @psalm-var array<array-key,string|null>|string|null $class */
                $class = $this->hintAttributes['class'] ?? null;
                unset($hintAttributes['class']);

                $hint = $hint->addAttributes($hintAttributes);

                if ($this->replaceHintClass) {
                    $hint = is_array($class) ? $hint->class(...$class) : $hint->class($class);
                } elseif ($class !== null) {
                    $hint = is_array($class) ? $hint->addClass(...$class) : $hint->addClass($class);
                }
            }
        }

        return $this->renderHint($hint);
    }

    private function generateError(): string
    {
        $error = Error::widget([], $this->errorConfig);

        $errorAttributes = $this->errorAttributes;
        if (!empty($errorAttributes)) {
            if ($this->replaceErrorAttributes) {
                $error = $error->attributes($errorAttributes);
            } else {
                /** @psalm-var array<array-key,string|null>|string|null $class */
                $class = $this->errorAttributes['class'] ?? null;
                unset($errorAttributes['class']);

                $error = $error->addAttributes($errorAttributes);

                if ($this->replaceErrorClass) {
                    $error = is_array($class) ? $error->class(...$class) : $error->class($class);
                } elseif ($class !== null) {
                    $error = is_array($class) ? $error->addClass(...$class) : $error->addClass($class);
                }
            }
        }

        return $this->renderError($error);
    }

    /**
     * @psalm-assert non-empty-string $token
     */
    private function validateToken(string $token): void
    {
        if ($token === '') {
            throw new InvalidArgumentException('Token must be non-empty string.');
        }

        if (in_array($token, self::BUILTIN_TOKENS, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Token name "%s" is built-in.',
                    $token,
                ),
            );
        }
    }
}
