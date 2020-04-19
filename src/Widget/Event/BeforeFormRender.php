<?php

namespace Yiisoft\Form\Widget\Event;

use Yiisoft\Form\Widget\FieldBuilder;

class BeforeFormRender
{
    private ?FieldBuilder $field = null;

    public function __construct(FieldBuilder $field)
    {
        $this->field = $field;
    }

    public function field(): FieldBuilder
    {
        return $this->field;
    }
}
