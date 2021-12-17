<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Html\Html;

use function is_string;

/**
 * @psalm-import-type HtmlAttributes from Html
 */
final class InputText extends AbstractField
{
    use PlaceholderTrait;

    /**
     * @psalm-var HtmlAttributes
     */
    private array $inputTagAttributes = [];

    /**
     * @psalm-param HtmlAttributes $attributes
     */
    public function inputTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputTagAttributes = $attributes;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Text widget must be a string or null value.');
        }

        $tag = Html::textInput($this->getInputName(), $value, $this->inputTagAttributes);

        $tag = $this->prepareIdInInputTag($tag);
        $tag = $this->preparePlaceholderInInputTag($tag);

        return $tag->render();
    }
}
