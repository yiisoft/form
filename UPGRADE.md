# Upgrading Instructions for Yii Form

> **Important!** The following upgrading instructions are cumulative. That is, if you want
> to upgrade from version A to version C and there is version B between A and C, you need
> to follow the instructions for both A and B.

## Upgrade from 1.x

### Checkbox::enclosedByLabel() removed

The method `Checkbox::enclosedByLabel()` was deprecated since version 1.2.0
and has been removed in 2.0.0.

Use `labelPlacement()` with one of the `CheckboxLabelPlacement` enum cases instead:

- `enclosedByLabel(true)` → `labelPlacement(CheckboxLabelPlacement::WRAP)`
- `enclosedByLabel(false)` → `labelPlacement(CheckboxLabelPlacement::DEFAULT)`
