<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

use function is_string;

final class InputText extends AbstractField
{
    use PlaceholderTrait;

    private ?Input $tag = null;

    public function inputTag(?Input $tag): self
    {
        if ($tag !== null && $tag->getAttribute('type') !== 'text') {
            throw new InvalidArgumentException('Input tag should be with type "text".');
        }

        $new = clone $this;
        $new->tag = $tag;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        $tag = $this->tag === null
            ? Html::textInput($this->getInputName(), $value)
            : $this->tag->name($this->getInputName())->value($value);

        $tag = $this->prepareIdInInputTag($tag);
        $tag = $this->preparePlaceholderInInputTag($tag);

        return $tag->render();
    }
}
