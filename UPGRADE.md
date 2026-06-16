# UPGRADE from 1.x to 2.0

## Hidden no longer extends InputField

`Hidden` now extends `BaseField` directly instead of `InputField` (`PartsField`).
The following methods are no longer available on a `Hidden` instance and calling
them causes a **compile-time error**:

- `label()`, `hint()`, `error()`
- `template()`, `templateBegin()`, `templateEnd()`
- `inputContainerTag()`, `inputContainerAttributes()`, `inputContainerClass()`,
  `addInputContainerClass()`
- `beforeInput()`, `afterInput()`
- `labelConfig()`, `hintConfig()`, `errorConfig()`
- `useContainer()`
