#Campo URL

Representa o elemento `<input>` do tipo "url" que permite ao usuário inserir e editar uma URL. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#url-state-(type=url))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/url)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?string $site = null;

    public function getAttributeLabels(): array
    {
        return [
            'site' => 'Your site',
        ];
    }
}
```

Widget:

```php
echo Url::widget()->formAttribute($profileForm, 'site');
```

O resultado será:

```html
<div>
    <label for="profileform-site">Your site</label>
    <input type="url" id="profileform-site" name="ProfileForm[site]">
</div>
```

## Valores suportados

- `string`
- `null`
