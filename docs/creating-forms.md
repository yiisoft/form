# Creating Forms

A form, that is displayed on the client-side, will in most cases have a corresponding form model which is used to
[validate input](https://github.com/yiisoft/validator).

In the following example, we show how a generic form model can be used for a login form:

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Translator\TranslatorInterface;

final class LoginForm extends FormModel
{
    // Define properties with TypeHint for validation
    private ?string $login = null;
    private ?string $password = null;
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    // Getters properties
    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getAttributeHints(): array
    {
        return [
            'login' => $this->translator->translate('Username'),
            'password' => $this->translator->translate('Password'),
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'login' => $this->translator->translate('Username'),
            'password' => $this->translator->translate('Password'),
        ];
    }

    public function getAttributePlaceholders(): array;
    {
        return [
            'login' => $this->translator->translate('Enter your username'),
            'password' => $this->translator->translate('Enter your password'),
        ];
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
        ];
    }
}
```

In the controller, we will pass an instance of that `formModel` to the `view`:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModel;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Translator\Translator;
use Yiisoft\View\WebView;
use Yiisoft\Yii\View\Csrf;

/**
 * @var FormModel $formModel
 * @var Csrf $csrf
 * @var Translator $translator
 * @var UrlGeneratorInterface $urlGenerator
 * @var WebView $this
 */

$title = $translator->translate('Log in');

$this->setTitle($title);
?>

<div class="card shadow mx-auto col-md-4">
    <h1 class="card-header fw-normal h3 text-center">
        <?= Html::encode($title) ?>
    </h1>
    <div class="card-body mt-2">
        <?= Html::form()
            ->post($urlGenerator->generate('login'))
            ->csrf($csrf)
            ->id('form-auth-login')
            ->open() ?>
            <?= Field::text($formModel, 'login')->autofocus()->tabindex(1) ?>
            <?= Field::password($formModel, 'password')->tabindex(2) ?>
            <?= Field::submitButton()
                ->containerClass('d-grid gap-2 form-floating')
                ->buttonClass('btn btn-primary btn-lg mt-3')
                ->buttonId('login-button')
                ->tabindex(3)
                ->content($translator->translate('Log in') ?>
        <?= '</form>' ?>
    </div>
</div>
```
