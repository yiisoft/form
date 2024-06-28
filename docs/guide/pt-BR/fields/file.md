# Campo de arquivo

Representa o elemento `<input>` do tipo "file" que permite ao usuário escolher um ou mais arquivos do armazenamento do dispositivo.
Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#file-upload-state-(type=file))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/file)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    private ?string $avatar = null;

    public function getAttributeLabels(): array
    {
        return [
            'avatar' => 'Choose a profile picture',
        ];
    }
}
```

Widget:

```php
echo File::widget()
    ->formAttribute($profileForm, 'avatar')
    ->accept('image/png, image/jpeg');
```

O resultado será:

```html
<div>
    <label for="profileform-avatar">Choose a profile picture</label>
    <input type="file" id="profileform-avatar" name="ProfileForm[avatar]" accept="image/png, image/jpeg">
</div>
```

## Valores suportados

- `string`
- `null`
- quaisquer valores stringáveis