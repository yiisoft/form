<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Nested;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class FormWithNestedProperty extends FormModel implements RulesProviderInterface
{
    private ?int $id = null;
    private LoginForm $user;

    public function __construct()
    {
        $this->user = new LoginForm();
    }

    public function getAttributeLabels(): array
    {
        return [
            'id' => 'ID',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'id' => 'Readonly ID',
        ];
    }

    public function getAttributePlaceholders(): array
    {
        return [
            'id' => 'Type ID.',
        ];
    }

    public function getRules(): array
    {
        return [
            'id' => [new Required()],
            'user' => new Nested(),
        ];
    }

    public function setUserLogin(string $login): void
    {
        $this->user->login($login);
    }

    public function getUserLogin(): ?string
    {
        return $this->user->getLogin();
    }
}
