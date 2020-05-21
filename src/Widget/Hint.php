<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;
use Yiisoft\Form\FormModelInterface;

final class Hint extends Widget
{
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];

    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $hint = ArrayHelper::remove($new->options, 'hint', $new->data->attributeHint($new->attribute));

        if (empty($hint)) {
            return '';
        }

        $tag = ArrayHelper::remove($new->options, 'tag', 'div');

        return Html::tag($tag, $hint, $new->options);
    }

    /**
     * Set form model, name and options for the widget.
     *
     * @param FormModelInterface $data Form model.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $options The HTML attributes for the widget container tag.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return self
     */
    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    /**
     * This specifies the hint to be displayed.
     *
     * Note that this will NOT be encoded.
     * If this is not set, {@see \Yiisoft\Yii\Form\FormModel::getAttributeHint()} will be called to get the hint for
     * display (without encoding).
     *
     * @param string $value
     *
     * @return self
     */
    public function hint(string $value): self
    {
        $new = clone $this;
        $new->options['hint'] = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Null to render hint without container {@see Html::tag()}.
     *
     * @param string|null $value
     *
     * @return self
     */
    public function tag(?string $value = null): self
    {
        $new = clone $this;
        $new->options['tag'] = $value;
        return $new;
    }
}
