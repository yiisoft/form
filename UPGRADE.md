# UPGRADE from 1.x to 2.0

## Checkbox::enclosedByLabel() removed

The method `Checkbox::enclosedByLabel()` was deprecated since version 1.2.0
and has been removed in 2.0.0.

Use `labelPlacement()` with one of the `CheckboxLabelPlacement` enum cases instead:

- `enclosedByLabel(true)` → `labelPlacement(CheckboxLabelPlacement::WRAP)`
- `enclosedByLabel(false)` → `labelPlacement(CheckboxLabelPlacement::DEFAULT)`
