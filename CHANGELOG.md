# Yii Form Change Log

## 1.3.1 under development

- Enh #367: Improve "Bootstrap 5 Horizontal" theme for checkbox (@vjik)
- Chg #370: Change PHP constraint in `composer.json` to `8.1 - 8.4` (@vjik)
- Bug #371: Suppress all extra HTML for "Hidden" field (@vjik)
- Enh #372: In `PartsFeild` class change `$beforeInput` and `$afterInput` properties' scope to protected (@vjik)

## 1.3.0 October 30, 2024

- New #366: Add `CheckboxList` methods: `checkboxWrapTag()`, `checkboxWrapAttributes()`, `checkboxWrapClass()`,
  `addCheckboxWrapClass()` and `checkboxLabelWrap()` (@vjik)
- New #366: Add `RadioList` methods: `radioWrapTag()`, `radioWrapAttributes()`, `radioWrapClass()`, `addRadioWrapClass`
  and `radioLabelWrap()` (@vjik)
- Enh #366: Improve HTML markup of checkbox and radio lists in Bootstrap 5 themes (@vjik)

## 1.2.0 October 09, 2024

- New #364: Add `Checkbox::labelPlacement()` method and mark `Checkbox::enclosedByLabel()` as deprecated (@vjik)

## 1.1.0 September 26, 2024

- Enh #363: Add backed enumeration value support to `Select` field (@vjik)

## 1.0.0 August 26, 2024

- Initial release.
