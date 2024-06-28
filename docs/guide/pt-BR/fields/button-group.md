# Campo de grupo de botões

Representa um widget de grupo de botões.

## Exemplo de uso

Widget:

```php
echo ButtonGroup::widget()
    ->buttons(
        Html::resetButton('Reset Data'),
        Html::submitButton('Send'),
    );
```

O resultado será:

```html
<div>
    <button type="reset">Reset Data</button>
    <button type="submit">Send</button>
</div>
```
