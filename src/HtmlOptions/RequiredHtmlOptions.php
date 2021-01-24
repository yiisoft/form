<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RuleInterface;

final class RequiredHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use RuleAwareTrait;

    private bool $ariaAttribute = false;

    public function __construct(Required $rule)
    {
        $this->rule = $rule;
    }

    public function withAriaAttribute(bool $value): self
    {
        $new = clone $this;
        $new->ariaAttribute = $value;
        return $new;
    }

    public function getHtmlOptions(): array
    {
        return [
            'required' => true,
            'aria-required' => $this->ariaAttribute ? 'true' : false,
        ];
    }
}
