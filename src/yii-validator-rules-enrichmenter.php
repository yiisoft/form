<?php

declare(strict_types=1);

use Yiisoft\Form\Field\Base\DateTimeInputField;
use Yiisoft\Form\Field\Email;
use Yiisoft\Form\Field\File;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Field\Select;
use Yiisoft\Form\Field\Telephone;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Field\Textarea;
use Yiisoft\Form\Field\Url;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Helper\RulesNormalizer;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Number as NumberRule;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url as UrlRule;
use Yiisoft\Validator\WhenInterface;

/**
 * @psalm-import-type NormalizedRulesList from RulesNormalizer
 * @psalm-var NormalizedRulesList $validationRules
 * @psalm-suppress InaccessibleProperty
 * @psalm-suppress InvalidScope
 */
return [
    function (mixed $validationRules): void {
        if ($this instanceof DateTimeInputField) {
            /** @var DateTimeInputField $this */
            foreach ($validationRules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $this->inputAttributes['required'] = true;
                }
            }
        }
    },

    Email::class => function (mixed $validationRules): void {
        /** @var Email $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof Length) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['minlength'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['maxlength'] = $max;
                }
            }

            if ($rule instanceof Regex) {
                if (!$rule->isNot()) {
                    $this->inputAttributes['pattern'] = Html::normalizeRegexpPattern(
                        $rule->getPattern()
                    );
                }
            }
        }
    },

    File::class => function (mixed $validationRules): void {
        /** @var File $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }
        }
    },

    Number::class => function (mixed $validationRules): void {
        /** @var Number $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof NumberRule) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['min'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['max'] = $max;
                }
            }
        }
    },

    Password::class => function (mixed $validationRules): void {
        /** @var Password $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof Length) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['minlength'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['maxlength'] = $max;
                }
            }

            if ($rule instanceof Regex) {
                if (!$rule->isNot()) {
                    $this->inputAttributes['pattern'] = Html::normalizeRegexpPattern(
                        $rule->getPattern()
                    );
                }
            }
        }
    },

    Range::class => function (mixed $validationRules): void {
        /** @var Range $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof NumberRule) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['min'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['max'] = $max;
                }
            }
        }
    },

    Select::class => function (mixed $validationRules): void {
        /** @var Select $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }
        }
    },

    Telephone::class => function (mixed $validationRules): void {
        /** @var Telephone $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof Length) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['minlength'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['maxlength'] = $max;
                }
            }

            if ($rule instanceof Regex) {
                if (!$rule->isNot()) {
                    $this->inputAttributes['pattern'] = Html::normalizeRegexpPattern(
                        $rule->getPattern()
                    );
                }
            }
        }
    },

    Text::class => function (mixed $validationRules): void {
        /** @var Text $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof Length) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['minlength'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['maxlength'] = $max;
                }
            }

            if ($rule instanceof Regex) {
                if (!$rule->isNot()) {
                    $this->inputAttributes['pattern'] = Html::normalizeRegexpPattern(
                        $rule->getPattern()
                    );
                }
            }
        }
    },

    Textarea::class => function (mixed $validationRules): void {
        /** @var Textarea $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof Length) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['minlength'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['maxlength'] = $max;
                }
            }
        }
    },

    Url::class => function (mixed $validationRules): void {
        /** @var Url $this */
        foreach ($validationRules as $rule) {
            if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                continue;
            }

            if ($rule instanceof Required) {
                $this->inputAttributes['required'] = true;
            }

            if ($rule instanceof Length) {
                if (null !== $min = $rule->getMin()) {
                    $this->inputAttributes['minlength'] = $min;
                }
                if (null !== $max = $rule->getMax()) {
                    $this->inputAttributes['maxlength'] = $max;
                }
            }

            $pattern = null;
            if ($rule instanceof UrlRule) {
                $pattern = $rule->isIdnEnabled() ? null : $rule->getPattern();
            }
            if ($pattern === null && $rule instanceof Regex) {
                if (!$rule->isNot()) {
                    $pattern = $rule->getPattern();
                }
            }
            if ($pattern !== null) {
                $this->inputAttributes['pattern'] = Html::normalizeRegexpPattern($pattern);
            }
        }
    },
];
