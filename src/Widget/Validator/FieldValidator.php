<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Validator;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Attribute\WidgetAttributes;
use Yiisoft\Form\Widget\Url;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\HasLength\HasLength;
use Yiisoft\Validator\Rule\Number\Number;
use Yiisoft\Validator\Rule\Regex\Regex;
use Yiisoft\Validator\Rule\Required\Required;
use Yiisoft\Validator\Rule\Url\Url as UrlRule;
use Yiisoft\Validator\RuleInterface;

/**
 * FieldValidator is a base class for validators that can be applied to a field.
 *
 * @param WidgetAttributes $widget The field widget.
 * @param FormModelInterface $formModel The form model instance.
 * @param string $attribute The attribute name or expression.
 * @param array $attributes The HTML attributes for the field widget.
 *
 * @return array The attributes for validator html.
 */
final class FieldValidator
{
    public function getValidatorAttributes(
        WidgetAttributes $widget,
        FormModelInterface $formModel,
        string $attribute,
        array $attributes
    ): array {
        /** @psalm-var array<array-key, RuleInterface> */
        $rules = $formModel->getRules()[$attribute] ?? [];

        foreach ($rules as $rule) {
            if ($rule instanceof Required) {
                $attributes['required'] = true;
            }

            if ($rule instanceof HasLength && $widget instanceof HasLengthInterface) {
                /** @var int|null */
                $attributes['maxlength'] = $rule->getOptions()['max'] !== null ? $rule->getOptions()['max'] : null;
                /** @var int|null */
                $attributes['minlength'] = $rule->getOptions()['min'] !== null ? $rule->getOptions()['min'] : null;
            }

            if ($rule instanceof Regex && $widget instanceof RegexInterface) {
                /** @var string */
                $pattern = $rule->getOptions()['pattern'];
                $attributes['pattern'] = Html::normalizeRegexpPattern($pattern);
            }

            if ($rule instanceof Number && $widget instanceof NumberInterface) {
                /** @var int|null */
                $attributes['max'] = $rule->getOptions()['max'] !== null ? $rule->getOptions()['max'] : null;
                /** @var int|null */
                $attributes['min'] = $rule->getOptions()['min'] !== null ? $rule->getOptions()['min'] : null;
            }

            if ($rule instanceof UrlRule && $widget instanceof Url) {
                /** @var array<array-key, string> */
                $validSchemes = $rule->getOptions()['validSchemes'];

                $schemes = [];

                foreach ($validSchemes as $scheme) {
                    $schemes[] = $this->getSchemePattern($scheme);
                }

                /** @var array<array-key, float|int|string>|string */
                $pattern = $rule->getOptions()['pattern'];
                $normalizePattern = str_replace('{schemes}', '(' . implode('|', $schemes) . ')', $pattern);
                $attributes['pattern'] = Html::normalizeRegexpPattern($normalizePattern);
            }
        }

        return $attributes;
    }

    private function getSchemePattern(string $scheme): string
    {
        $result = '';

        for ($i = 0, $length = strlen($scheme); $i < $length; $i++) {
            $result .= '[' . strtolower($scheme[$i]) . strtoupper($scheme[$i]) . ']';
        }

        return $result;
    }
}
