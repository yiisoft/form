<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Stringable;
use Yiisoft\Form\Field\Base\FieldContentTrait;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Html\Tag\Fieldset as FieldsetTag;
use Yiisoft\Html\Tag\Legend;

/**
 * Represents `<fieldset>` element are use to group several controls.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-fieldset-element
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/fieldset
 */
final class Fieldset extends PartsField
{
    use FieldContentTrait;

    private FieldsetTag $tag;

    public function __construct()
    {
        $this->tag = FieldsetTag::tag();
    }

    public function legend(string|Stringable|null $content, array $attributes = []): self
    {
        $new = clone $this;
        $new->tag = $this->tag->legend($content, $attributes);
        return $new;
    }

    public function legendTag(?Legend $legend): self
    {
        $new = clone $this;
        $new->tag = $this->tag->legendTag($legend);
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-fieldset-disabled
     *
     * @param bool $disabled Whether fieldset is disabled.
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->tag = $this->tag->disabled($disabled);
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->tag = $this->tag->form($formId);
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-name
     */
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->tag = $this->tag->name($name);
        return $new;
    }

    protected function generateInput(): string
    {
        return $this->generateBeginInput()
            . "\n"
            . $this->generateEndInput();
    }

    protected function generateBeginInput(): string
    {
        return $this->tag->open();
    }

    protected function generateEndInput(): string
    {
        $content = $this->renderContent();

        return ($content !== '' ? $content . "\n" : '')
            . $this->tag->close();
    }
}
