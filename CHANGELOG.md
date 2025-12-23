# Yii Form Change Log

## 1.5.1 December 23, 2025

- Enh #383: Add PHP 8.5 support (@vjik)

## 1.5.0 November 05, 2025

- New #377: Add `Color` field (@samdark)
- Enh #379: Improve `Fieldset` field HTML markup (@vjik)
- Bug #379: Fix newline removal issues in input values (@vjik)

## 1.4.0 March 27, 2025

- Chg #370: Change PHP constraint in `composer.json` to `8.1 - 8.4` (@vjik)
- Enh #367: Improve "Bootstrap 5 Horizontal" theme for checkbox (@vjik)
- Enh #372: In `PartsFeild` class change `$beforeInput` and `$afterInput` properties' scope to protected (@vjik)
- Bug #371: Suppress all extra HTML for "Hidden" field (@vjik)

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
