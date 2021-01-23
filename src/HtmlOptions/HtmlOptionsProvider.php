<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

/**
 * Provides options for HTML input tags.
 */
interface HtmlOptionsProvider
{
    /**
     * @return array Options for HTML input tags in `['optionName' => 'optionValue']` format.
     */
    public function getHtmlOptions(): array;
}
