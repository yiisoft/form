# Creating Forms

The primary way of using forms in `Yii` is through `Yiisoft\Form\Widget\Form` this approach should be preferred when the form is based upon a form model. Additionally, there are some useful `widgets` that are typically used for adding buttons and help text to any form.

A form, that is displayed on the client-side, will in most cases have a corresponding form model which is used to validate (Check the [Validating Input section for more details on validation](https://github.com/yiisoft/validator)). 

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

    // Setters properties
    public function login(string $value): void
    {
        $this->login = $value;
    }

    public function password(string $value): void
    {
        $this->password = $value;
    }

    public function getAttributeHints(): array
    {
        return [
            'login' => $this->translator->translate('Username'),
            'password' => $this->translator->translate('Password'),
        ];
    }

    public function attributeLabels(): array
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

    // Define form name
    public function formName(): string
    {
        return 'LoginForm';
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
        ];
    }
}
```

In the controller, we will pass an instance of that `formModel` to the `view`, wherein the `Form` widget is used to display the form:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModel;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Html\Html;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Translator\Translator;
use Yiisoft\View\WebView;

/**
 * @var Field $field
 * @var FormModel $formModel
 * @var object $csrf
 * @var Translator $translator
 * @var UrlGeneratorInterface $urlGenerator
 * @var WebView $this
 */

$title = Html::encode($translator->translate('Log in'));

/** @psalm-suppress InvalidScope */
$this->setTitle($title);
?>

<div class="card shadow mx-auto col-md-4">
    <h1 class="card-header fw-normal h3 text-center">
        <?= $title ?>
    </h1>
    <div class="card-body mt-2">
        <?= Form::widget()
            ->action($urlGenerator->generate('login'))
            ->csrf($csrf)
            ->id('form-auth-login')
            ->begin() ?>

            <?= $field->config($formModel, 'login')->text(['autofocus' => true, 'tabindex' => 1]) ?>

            <?= $field->config($formModel, 'password')->password(['tabindex' => 2]) ?>

            <?= $field->containerClass('d-grid gap-2 form-floating')
                ->submitButton(
                    [
                        'class' => 'btn btn-primary btn-lg mt-3',
                        'id' => 'login-button',
                        'tabindex' => 3,
                        'value' => $translator->translate('Log in'),
                    ]
                )
            ?>
        <?= Form::end() ?>
    </div>
</div>
```

### Wrapping with and `begin()` `end()`

In the above code, `Form::begin()` not only creates a form instance, but also marks the beginning of the `form`. All of the content placed between `Form::begin()` and `Form::end()` will be wrapped within the `HTML` tag, `<form>content<form>`.


