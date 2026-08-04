# Upgrading Instructions for Yii Form

This file contains the upgrade notes. These notes highlight changes that could break your
application when you upgrade the package from one version to another.

> **Important!** The following upgrading instructions are cumulative. That is, if you want
> to upgrade from version A to version C and there is version B between A and C, you need
> to follow the instructions for both A and B.

## Upgrade from 1.x

- `Hidden` no longer extends `InputField`. It now extends `BaseField` directly. The following
  methods are no longer available:
  `label()`, `hint()`, `error()`, `template()`, `templateBegin()`, `templateEnd()`,
  `inputContainerTag()`, `inputContainerAttributes()`, `inputContainerClass()`,
  `addInputContainerClass()`, `beforeInput()`, `afterInput()`, `labelConfig()`, `hintConfig()`,
  `errorConfig()`, `useContainer()`.
