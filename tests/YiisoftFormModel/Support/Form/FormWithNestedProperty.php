<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\YiisoftFormModel\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Form\Tests\YiisoftFormModel\Support\Dto\Coordinates;
use Yiisoft\Validator\Rule\Nested;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class FormWithNestedProperty extends FormModel implements RulesProviderInterface
{
    private ?int $id = null;
    private string $key = '';
    private array $meta = [];
    private Coordinates $coordinates;
    private LoginForm $user;

    public function __construct()
    {
        $this->user = new LoginForm();
        $this->coordinates = new Coordinates();
    }

    public function getPropertyLabels(): array
    {
        return [
            'id' => 'ID',
        ];
    }

    public function getPropertyHints(): array
    {
        return [
            'id' => 'Readonly ID',
        ];
    }

    public function getPropertyPlaceholders(): array
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
