# Campo de imagem

Representa o elemento `<input>` do tipo "image" que é usado para criar botões gráficos de envio. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#image-button-state-(type=image))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/image)

## Exemplo de uso

Widget:

```php
echo Image::widget()
    ->src('btn.png')
    ->alt('Go');
```

O resultado será:

```html
<div>
    <input type="image" src="btn.png" alt="Go">
</div>
```
