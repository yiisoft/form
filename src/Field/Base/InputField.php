<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\Field\Base\InputData\InputDataWithCustomNameAndValueTrait;
use Yiisoft\Form\Field\Base\InputTag\InputTagMethodsTrait;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

abstract class InputField extends PartsField
{
    use InputDataWithCustomNameAndValueTrait;
    use InputTagMethodsTrait;

    final protected function renderLabel(Label $label): string
    {
        $label = $label->inputData($this->getInputData());

        if ($this->shouldSetInputId === false) {
            $label = $label->useInputId(false);
        }

        if ($this->inputId !== null) {
            $label = $label->forId($this->inputId);
        } elseif ($this->inputIdFromTag !== null) {
            $label = $label->forId($this->inputIdFromTag);
        }

        return $label->render();
    }

    final protected function renderHint(Hint $hint): string
    {
        return $hint
            ->inputData($this->getInputData())
            ->render();
    }

    final protected function renderError(Error $error): string
    {
        return $error
            ->inputData($this->getInputData())
            ->render();
    }
}
