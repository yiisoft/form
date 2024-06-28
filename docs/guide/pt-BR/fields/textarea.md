# Campo de área de texto

Representa o elemento `<textarea>` que cria um controle de edição de texto multilinhas. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-textarea-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/textarea)

## Exemplo de uso

Modelo de formulário:

```php
final class ProductForm extends FormModel
{
    public ?string $shortdesc = null;

    public function getAttributeLabels(): array
    {
        return [
            'shortdesc' => 'Short description',
        ];
    }
}
```

Widget:

```php
echo Textarea::widget()
    ->formAttribute($productForm, 'shortdesc')
    ->rows(7);
```

O resultado será:

```html
<div>
    <label for="productform-shortdesc">Short description</label>
    <textarea id="productform-shortdesc" name="ProductForm[shortdesc]" rows="7"></textarea>
</div>
```

## Valores suportados

- `string`
- `null`
