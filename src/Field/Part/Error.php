<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\FormAttributeTrait;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

use function call_user_func;

/**
 * Represent a field validation error (if there are several errors, the first one is used). If field is no validation
 * error, field part will be hidden.
 */
final class Error extends Widget
{
    use FormAttributeTrait;

    /**
     * @psalm-var non-empty-string
     */
    private string $tag = 'div';
    private array $tagAttributes = [];

    private bool $encode = true;

    private ?string $message = null;

    /**
     * @var callable|null
     */
    private $messageCallback = null;

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

    public function tagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->tagAttributes = $attributes;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * Error message to display.
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
     * @param callable|null $value
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
        $useModel = $this->hasFormModelAndAttribute();

        $message = $useModel
            ? $this->message ?? $this->getFirstError()
            : $this->message;

        if ($message === null) {
            return '';
        }

        if ($this->messageCallback !== null) {
            /** @var string $message */
            $message = call_user_func(
                $this->messageCallback,
                $message,
                $useModel ? $this->getFormModel() : null,
                $useModel ? $this->attribute : null
            );
        }

        return CustomTag::name($this->tag)
            ->attributes($this->tagAttributes)
            ->content($message)
            ->encode($this->encode)
            ->render();
    }
}
