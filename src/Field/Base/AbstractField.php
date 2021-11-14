<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Html\Tag\Base\TagContentInterface;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Label;
use Yiisoft\Widget\Widget;

abstract class AbstractField extends Widget
{
    private ?FormModelInterface $formModel = null;
    private string $attribute = '';

    private ?TagContentInterface $containerTag = null;
    private bool $withoutContainer = false;

    private string $template = "{label}\n{input}\n{hint}\n{error}";

    private ?string $inputId = null;
    private bool $setInputIdAttribute = true;

    private ?Label $labelTag = null;
    private ?string $labelContent = null;
    private bool $setLabelForAttribute = true;

    private ?TagContentInterface $hintTag = null;
    private ?string $hintContent = null;

    /**
     * @return static
     */
    final public function attribute(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    final public function containerTag(?TagContentInterface $tag): self
    {
        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    final public function withoutContainer(): self
    {
        $new = clone $this;
        $new->withoutContainer = true;
        return $new;
    }

    /**
     * Set layout template for render a field.
     *
     * @param string $template
     *
     * @return static
     */
    final public function template(string $template): self
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    final public function id(?string $id): self
    {
        $new = clone $this;
        $new->inputId = $id;
        return $new;
    }

    final public function doNotSetInputIdAttribute(): self
    {
        $new = clone $this;
        $new->setInputIdAttribute = false;
        return $new;
    }

    final public function labelTag(?Label $tag): self
    {
        $new = clone $this;
        $new->labelTag = $tag;
        return $new;
    }

    final public function label(?string $content): self
    {
        $new = clone $this;
        $new->labelContent = $content;
        return $new;
    }

    final public function doNotSetLabelForAttribute(): self
    {
        $new = clone $this;
        $new->setLabelForAttribute = false;
        return $new;
    }

    final public function hintTag(?TagContentInterface $tag): self
    {
        $new = clone $this;
        $new->hintTag = $tag;
        return $new;
    }

    final public function hint(?string $content): self
    {
        $new = clone $this;
        $new->hintContent = $content;
        return $new;
    }

    final protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    final protected function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->attribute);
    }

    final protected function getInputId(): ?string
    {
        if (!$this->setInputIdAttribute) {
            return null;
        }

        return $this->inputId ?? HtmlForm::getInputId($this->getFormModel(), $this->attribute);
    }

    /**
     * @return bool|float|int|iterable|object|string|Stringable|null
     */
    final protected function getAttributeValue()
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributeLabel(): string
    {
        return HtmlForm::getAttributeLabel($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributeHint(): string
    {
        return HtmlForm::getAttributeHint($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributePlaceholder(): ?string
    {
        return $this->getFormModel()->getAttributePlaceholder($this->attribute);
    }

    final protected function prepareIdInInputTag(Tag $tag): Tag
    {
        if (
            $this->setInputIdAttribute
            && $tag->getAttribute('id') === null
        ) {
            $id = $this->getInputId();
            if ($id !== null) {
                $tag = $tag->id($id);
            }
        }

        return $tag;
    }

    final protected function run(): string
    {
        if ($this->withoutContainer) {
            return $this->generateContent();
        }

        $containerTag = $this->containerTag ?? Div::tag();

        return $containerTag->open()
            . PHP_EOL
            . $this->generateContent()
            . PHP_EOL
            . $containerTag->close();
    }

    abstract protected function generateInput(): string;

    private function generateContent(): string
    {
        $parts = [
            '{label}' => $this->generateLabel(),
            '{input}' => $this->generateInput(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->template, $parts)));
    }

    private function generateLabel(): string
    {
        $tag = $this->labelTag ?? Label::tag();

        if ($this->labelContent !== null) {
            $tag = $tag->content($this->labelContent);
        } elseif ($tag->getContent() === '') {
            $tag = $tag->content($this->getAttributeLabel());
        }

        if (
            $this->setLabelForAttribute
            && $tag->getAttribute('for') === null
        ) {
            $id = $this->getInputId();
            if ($id !== null) {
                $tag = $tag->forId($id);
            }
        }

        return $tag->render();
    }

    private function generateHint(): string
    {
        $tag = $this->hintTag ?? Div::tag();

        if ($this->hintContent !== null) {
            $tag = $tag->content($this->hintContent);
        } elseif ($tag->getContent() === '') {
            $tag = $tag->content($this->getAttributeHint());
        }

        return $tag->render();
    }

    private function generateError(): string
    {
        return '';
    }
}
