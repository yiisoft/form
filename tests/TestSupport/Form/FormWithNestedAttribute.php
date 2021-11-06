<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormErrorsInterface;
use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;

final class FormWithNestedAttribute extends FormModel
{
    private ?int $id = null;
    private LoginForm $user;

    public function __construct(FormErrorsInterface $formErrors)
    {
        $this->user = new LoginForm($formErrors);
        parent::__construct($formErrors);
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
            'id' => Required::rule(),
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
