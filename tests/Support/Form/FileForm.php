<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class FileForm extends FormModel implements RulesProviderInterface
{
    private ?string $avatar = null;
    private ?string $image = null;
    private ?string $photo = null;

    public function getRules(): array
    {
        return [
            'image' => [new Required()],
            'photo' => [new Required(when: static fn () => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'avatar' => 'Avatar',
        ];
    }
}
