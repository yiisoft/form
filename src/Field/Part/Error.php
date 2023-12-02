<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\InputData\InputDataInterface;
use Yiisoft\Form\Field\Base\InputData\InputDataTrait;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * Represent a field validation error (if there are several errors, the first one is used). If field is no validation
 * error, field part will be hidden.
 *
 * @psalm-type MessageCallback = callable(string, InputDataInterface): string
 */
final class Error extends Widget
{
    use InputDataTrait;

    private bool $onlyFirst = false;

    /**
     * @psalm-var non-empty-string
     */
    private string $tag = 'div';
    private array $attributes = [];

    private bool $encode = true;

    private string $separator = "\n<br>\n";

    private ?string $header = null;

    /**
     * @var non-empty-string|null
     */
    private ?string $headerTag = 'div';
    private array $headerAttributes = [];
    private bool $headerEncode = true;

    /**
     * @psalm-var non-empty-string
     */
    private ?string $errorTag = null;
    private array $errorAttributes = [];

    /**
     * @psalm-var array<array-key,string>|null
     */
    private ?array $messages = null;

    /**
     * @var callable|null
     * @psalm-var MessageCallback|null
     */
    private $messageCallback = null;

    public function onlyFirst(bool $value = true): self
    {
        $new = clone $this;
        $new->onlyFirst = $value;
        return $new;
    }

    /**
     * Set the container tag name for the error.
     *
     * @param string $tag Container tag name.
     */
    public function tag(string $tag): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->tag = $tag;
        return $new;
    }

    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $attributes);
        return $new;
    }

    /**
     * Set tag ID.
     *
     * @param string|null $id Tag ID.
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Add one or more CSS classes to the tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function addClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Replace tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function class(?string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    /**
     * Whether error messages should be HTML-encoded.
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    public function header(?string $header): self
    {
        $new = clone $this;
        $new->header = $header;
        return $new;
    }

    /**
     * Set the header tag name.
     *
     * @param string|null $tag Header tag name.
     */
    public function headerTag(?string $tag): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->headerTag = $tag;
        return $new;
    }

    public function headerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = $attributes;
        return $new;
    }

    public function addHeaderAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = array_merge($this->headerAttributes, $attributes);
        return $new;
    }

    /**
     * Whether header content should be HTML-encoded.
     */
    public function headerEncode(bool $encode): self
    {
        $new = clone $this;
        $new->headerEncode = $encode;
        return $new;
    }

    /**
     * Set an error item tag name.
     *
     * @param string $tag Error item tag name.
     */
    public function errorTag(string $tag): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->errorTag = $tag;
        return $new;
    }

    public function errorAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->errorAttributes = $attributes;
        return $new;
    }

    public function addErrorAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->errorAttributes = array_merge($this->errorAttributes, $attributes);
        return $new;
    }

    /**
     * Error messages to display.
     */
    public function message(?string $message, string ...$messages): self
    {
        $new = clone $this;
        $new->messages = $message === null ? null : [$message, ...$messages];
        return $new;
    }

    /**
     * Callback that will be called to obtain an error message.
     *
     * @psalm-param MessageCallback|null $callback
     */
    public function messageCallback(?callable $callback): self
    {
        $new = clone $this;
        $new->messageCallback = $callback;
        return $new;
    }

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string The generated error tag.
     */
    public function render(): string
    {
        $messages = $this->messages ?? $this->getInputData()->getValidationErrors();
        if (empty($messages)) {
            return '';
        }

        if ($this->onlyFirst) {
            $messages = [reset($messages)];
        }

        $messageCallback = $this->messageCallback;
        if ($messageCallback !== null) {
            $messages = array_map(
                fn(string $message) => $messageCallback($message, $this->getInputData()),
                $messages,
            );
        }

        $content = [];

        if ($this->header !== null) {
            $content[] = $this->headerTag === null
                ? ($this->headerEncode ? Html::encode($this->header) : $this->header)
                : CustomTag::name($this->headerTag)
                    ->attributes($this->headerAttributes)
                    ->content($this->header)
                    ->encode($this->headerEncode)
                    ->render();
            $content[] = "\n";
        }

        $isFirst = true;
        foreach ($messages as $message) {
            if ($isFirst) {
                $isFirst = false;
            } else {
                $content[] = $this->separator;
            }
            $content[] = $this->errorTag === null
                ? ($this->encode ? Html::encode($message) : $message)
                : CustomTag::name($this->errorTag)
                    ->attributes($this->errorAttributes)
                    ->content($message)
                    ->encode($this->encode)
                    ->render();
        }

        return CustomTag::name($this->tag)
            ->addAttributes($this->attributes)
            ->content(...(count($messages) === 1 ? $content : ["\n", ...$content, "\n"]))
            ->encode(false)
            ->render();
    }

    protected static function getThemeConfig(?string $theme): array
    {
        return ThemeContainer::getTheme($theme)?->getErrorConfig() ?? [];
    }
}
