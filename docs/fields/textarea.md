# Textarea Field

Represents `<textarea>` element that create a multi-line plain-text editing control. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-textarea-element)
- [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/textarea)

## Usage Example

Form model:

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
    ->attribute($productForm, 'shortdesc')
    ->rows(7);
```

Result will be:

```html
<div>
    <label for="productform-shortdesc">Short description</label>
    <textarea id="productform-shortdesc" name="ProductForm[shortdesc]" rows="7"></textarea>
</div>
```

## Supported Values

- `string`
- `null`
