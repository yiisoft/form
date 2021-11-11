<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use Yiisoft\Html\Html;

trait WithoutModelAttribute
{
    private string $autoIdPrefix = '';
    private array $attributes = [];
    private string $id = '';

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @param string $value
     *
     * @return static
     */
    public function autoIdPrefix(string $value): self
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;
        return $new;
    }

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * Set the ID of the widget.
     *
     * @param string $id
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(string $id): self
    {
        $new = clone $this;
        $new->id = $id;
        return $new;
    }

    /**
     * Generates a unique ID for the attribute.
     *
     * @return string
     */
    protected function getId(): string
    {
        return $this->id = $this->id !== '' ? $this->id : Html::generateId($this->autoIdPrefix);
    }

    protected function getName(): string
    {
        $name = $this->getId();

        if (isset($this->attributes['name']) && is_string($this->attributes['name'])) {
            $name = $this->attributes['name'];
        }

        return $name;
    }
}
