<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

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

    private array $labelConfig = [];
    private array $hintConfig = [];
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

        return $this->renderLabel($label);
    }

    private function generateHint(): string
    {
        $hint = Hint::widget($this->hintConfig);

        return $this->renderHint($hint);
    }

    private function generateError(): string
    {
        $error = Error::widget($this->errorConfig);

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
