# Campo de caixa de seleção

Representa o elemento `<input>` do tipo "checkbox" que é renderizado por padrão como caixas marcadas (marcadas) quando
ativado. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#checkbox-state-(type=checkbox))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/checkbox)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public bool $subscribe = true;

    public function getAttributeLabels(): array
    {
        return [
            'subscribe' => 'Subscribe to mailing list',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'subscribe' => 'We send emails once a month.',
        ];
    }
}
```

Widget:

```php
echo Checkbox::widget()->formAttribute($profileForm, 'subscribe');
```

O resultado será:

```html
<div>
    <input type="hidden" name="ProfileForm[subscribe]" value="0">
    <label>
        <input type="checkbox" id="profileform-red" name="ProfileForm[subscribe]" value="1" checked> Subscribe to mailing list
    </label>
    <div>We send emails once a month.</div>
</div>
```

## Valores suportados

- `bool`
- `null`
- quaisquer valores stringáveis