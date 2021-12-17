<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\FormAttributeTrait;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

use function call_user_func;

final class Error extends Widget
{
    use FormAttributeTrait;

    /**
     * @psalm-var non-empty-string
     */
    private string $tag = 'div';
    private array $attributes = [];

    private bool $encode = true;

    private ?string $message = null;

    /**
     * @var callable|null
     */
    private $messageCallback = null;

    /**
     * Set the container tag name for the hint.
     *
     * @param string $tag Container tag name. Set to empty value to render error messages without container tag.
     *
     * @return static
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

    public function tagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * Error message to display.
     *
     * @return static
     */
    public function message(?string $value): self
    {
        $new = clone $this;
        $new->message = $value;
        return $new;
    }

    /**
     * Callback that will be called to obtain an error message.
     *
     * The signature of the callback must be:
     *
     * ```php
     * [$FormModel, function()]
     * ```
     *
     * @param callable|null $value
     *
     * @return static
     */
    public function messageCallback(?callable $value): self
    {
        $new = clone $this;
        $new->messageCallback = $value;
        return $new;
    }

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string The generated error tag.
     */
    protected function run(): string
    {
        $message = $this->getFirstError();
        if ($message === null) {
            return '';
        }

        if ($this->message !== null) {
            $message = $this->message;
        }

        if ($this->messageCallback !== null) {
            /** @var string $message */
            $message = call_user_func($this->messageCallback, $this->getFormModel(), $this->attribute, $message);
        }

        return CustomTag::name($this->tag)
            ->attributes($this->attributes)
            ->content($message)
            ->encode($this->encode)
            ->render();
    }
}
