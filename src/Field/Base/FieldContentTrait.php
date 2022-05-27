<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

/**
 * Adds functionality for processing with field content.
 */
trait FieldContentTrait
{
    private ?bool $encodeContent = null;
    private bool $doubleEncodeContent = true;

    /**
     * @psalm-var list<string|Stringable>
     */
    private array $content = [];

    /**
     * @param bool|null $encode Whether to encode field content. Supported values:
     *  - `null`: stringable objects that implement interface {@see NoEncodeStringableInterface} are not encoded,
     *    everything else is encoded;
     *  - `true`: any content is encoded;
     *  - `false`: nothing is encoded.
     * Defaults to `null`.
     */
    final public function encodeContent(?bool $encode): static
    {
        $new = clone $this;
        $new->encodeContent = $encode;
        return $new;
    }

    /**
     * @param bool $doubleEncode Whether already encoded HTML entities in field content should be encoded.
     * Defaults to `true`.
     */
    final public function doubleEncodeContent(bool $doubleEncode): static
    {
        $new = clone $this;
        $new->doubleEncodeContent = $doubleEncode;
        return $new;
    }

    /**
     * @param string|Stringable ...$content Field content.
     */
    final public function content(string|Stringable ...$content): static
    {
        $new = clone $this;
        $new->content = array_values($content);
        return $new;
    }

    /**
     * @param string|Stringable ...$content Field content.
     */
    final public function addContent(string|Stringable ...$content): static
    {
        $new = clone $this;
        $new->content = array_merge($new->content, array_values($content));
        return $new;
    }

    /**
     * @return string Obtain field content considering encoding options {@see encodeContent()}.
     */
    final protected function renderContent(): string
    {
        $content = '';

        foreach ($this->content as $item) {
            if ($this->encodeContent || ($this->encodeContent === null && !($item instanceof NoEncodeStringableInterface))) {
                $item = Html::encode($item, $this->doubleEncodeContent);
            }

            $content .= $item;
        }

        return $content;
    }
}
