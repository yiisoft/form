<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

interface HtmlOptionsProvider
{
    public function getHtmlOptions(): array;
}
