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

abstract class PartsField extends BaseField
{
    private const BUILTIN_TOKENS = [
        '{input}',
        '{label}',
        '{hint}',
        '{error}',
    ];

    /**
     * @var string[]|Stringable[]
     * @psalm-var array<non-empty-string,string|Stringable>
     */
    private array $extraTokens = [];

    protected string $templateBegin = "{label}\n{input}";
    protected string $templateEnd = "{input}\n{hint}\n{error}";
    protected string $template = "{label}\n{input}\n{hint}\n{error}";
    protected ?bool $hideLabel = null;

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
                        $token,
                    )
                );
            }

            if (!is_string($value) && !$value instanceof Stringable) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Token value should be string or Stringable. %s given.',
                        get_debug_type($value),
                    )
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
     * Add one or more CSS classes to the label tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function labelClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass(
            $new->labelAttributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    /**
     * Replace label tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function replaceLabelClass(?string ...$class): static
    {
        $new = clone $this;
        $new->labelAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        $new->replaceLabelClass = true;
        return $new;
    }

    final public function label(?string $content): static
    {
        $new = clone $this;
        $new->labelConfig['content()'] = [$content];
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
     * Add one or more CSS classes to the hint tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function hintClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass(
            $new->hintAttributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    /**
     * Replace hint tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function replaceHintClass(?string ...$class): static
    {
        $new = clone $this;
        $new->hintAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        $new->replaceHintClass = true;
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
     * Add one or more CSS classes to the error tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function errorClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass(
            $new->errorAttributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    /**
     * Replace error tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function replaceErrorClass(?string ...$class): static
    {
        $new = clone $this;
        $new->errorAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        $new->replaceErrorClass = true;
        return $new;
    }

    final public function error(?string $message): static
    {
        $new = clone $this;
        $new->errorConfig['message()'] = [$message];
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
            '{input}' => $this->generateInput(),
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

    private function makeContent(string $template, array $parts): string
    {
        if (!empty($this->extraTokens)) {
            $parts += $this->extraTokens;
        }

        return preg_replace('/^\h*\v+/m', '', trim(strtr($template, $parts)));
    }

    private function generateLabel(): string
    {
        $label = Label::widget($this->labelConfig);

        $labelAttributes = $this->labelAttributes;
        if (!empty($labelAttributes)) {
            if ($this->replaceLabelAttributes) {
                $label = $label->attributes($labelAttributes);
            } else {
                /** @var string|string[]|null $class */
                $class = $this->labelAttributes['class'] ?? null;
                unset($labelAttributes['class']);

                $label = $label->addAttributes($labelAttributes);

                if ($this->replaceLabelClass) {
                    $label = is_array($class) ? $label->replaceClass(...$class) : $label->replaceClass($class);
                } elseif ($class !== null) {
                    $label = is_array($class) ? $label->class(...$class) : $label->class($class);
                }
            }
        }

        return $this->renderLabel($label);
    }

    private function generateHint(): string
    {
        $hint = Hint::widget($this->hintConfig);

        $hintAttributes = $this->hintAttributes;
        if (!empty($hintAttributes)) {
            if ($this->replaceHintAttributes) {
                $hint = $hint->attributes($hintAttributes);
            } else {
                /** @var string|string[]|null $class */
                $class = $this->hintAttributes['class'] ?? null;
                unset($hintAttributes['class']);

                $hint = $hint->addAttributes($hintAttributes);

                if ($this->replaceHintClass) {
                    $hint = is_array($class) ? $hint->replaceClass(...$class) : $hint->replaceClass($class);
                } elseif ($class !== null) {
                    $hint = is_array($class) ? $hint->class(...$class) : $hint->class($class);
                }
            }
        }

        return $this->renderHint($hint);
    }

    private function generateError(): string
    {
        $error = Error::widget($this->errorConfig);

        $errorAttributes = $this->errorAttributes;
        if (!empty($errorAttributes)) {
            if ($this->replaceErrorAttributes) {
                $error = $error->attributes($errorAttributes);
            } else {
                /** @var string|string[]|null $class */
                $class = $this->errorAttributes['class'] ?? null;
                unset($errorAttributes['class']);

                $error = $error->addAttributes($errorAttributes);

                if ($this->replaceErrorClass) {
                    $error = is_array($class) ? $error->replaceClass(...$class) : $error->replaceClass($class);
                } elseif ($class !== null) {
                    $error = is_array($class) ? $error->class(...$class) : $error->class($class);
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
                )
            );
        }
    }
}
