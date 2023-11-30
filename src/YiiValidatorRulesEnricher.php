<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\Base\BaseField;
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
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Number as NumberRule;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url as UrlRule;
use Yiisoft\Validator\WhenInterface;

use function is_iterable;

final class YiiValidatorRulesEnricher implements ValidationRulesEnricherInterface
{
    public function process(BaseField $field, mixed $rules): ?array
    {
        if (!is_iterable($rules)) {
            return null;
        }

        if ($field instanceof DateTimeInputField) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }
            }
            return $enrichment;
        }

        if ($field instanceof Email) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof Length) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['maxlength'] = $max;
                    }
                }

                if ($rule instanceof Regex) {
                    if (!$rule->isNot()) {
                        $enrichment['inputAttributes']['pattern'] = Html::normalizeRegexpPattern(
                            $rule->getPattern()
                        );
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof File) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }
            }
            return $enrichment;
        }

        if ($field instanceof Number) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof NumberRule) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['min'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['max'] = $max;
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof Password) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof Length) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['maxlength'] = $max;
                    }
                }

                if ($rule instanceof Regex) {
                    if (!$rule->isNot()) {
                        $enrichment['inputAttributes']['pattern'] = Html::normalizeRegexpPattern(
                            $rule->getPattern()
                        );
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof Range) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof NumberRule) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['min'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['max'] = $max;
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof Select) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }
            }
            return $enrichment;
        }

        if ($field instanceof Telephone) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof Length) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['maxlength'] = $max;
                    }
                }

                if ($rule instanceof Regex) {
                    if (!$rule->isNot()) {
                        $enrichment['inputAttributes']['pattern'] = Html::normalizeRegexpPattern(
                            $rule->getPattern()
                        );
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof Text) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof Length) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['maxlength'] = $max;
                    }
                }

                if ($rule instanceof Regex) {
                    if (!$rule->isNot()) {
                        $enrichment['inputAttributes']['pattern'] = Html::normalizeRegexpPattern(
                            $rule->getPattern()
                        );
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof Textarea) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof Length) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['maxlength'] = $max;
                    }
                }
            }
            return $enrichment;
        }

        if ($field instanceof Url) {
            $enrichment = [];
            foreach ($rules as $rule) {
                if ($rule instanceof WhenInterface && $rule->getWhen() !== null) {
                    continue;
                }

                if ($rule instanceof Required) {
                    $enrichment['inputAttributes']['required'] = true;
                }

                if ($rule instanceof Length) {
                    if (null !== $min = $rule->getMin()) {
                        $enrichment['inputAttributes']['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getMax()) {
                        $enrichment['inputAttributes']['maxlength'] = $max;
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
                    $enrichment['inputAttributes']['pattern'] = Html::normalizeRegexpPattern($pattern);
                }
            }
            return $enrichment;
        }

        return null;
    }
}
