# Common field properties

BaseField

- containerTag
- containerAttributes / addContainerAttributes
- containerId
- containerClass / addContainerClass
- useContainer

PartsField

tokens(tokens: array): PartsField
token(token: string, value: string|Stringable): PartsField
template(template: string): PartsField
templateBegin(template: string): PartsField
templateEnd(template: string): PartsField
hideLabel([hide: bool|null = true]): PartsField
inputContainerTag(tag: null|string): PartsField
inputContainerAttributes(attributes: array): PartsField
addInputContainerAttributes(attributes: array): PartsField
inputContainerClass(...class: null|string): PartsField
addInputContainerClass(...class: null|string): PartsField
beforeInput(content: string|Stringable): PartsField
afterInput(content: string|Stringable): PartsField
labelConfig(config: array): PartsField
labelAttributes(attributes: array): PartsField
addLabelAttributes(attributes: array): PartsField
labelId(id: null|string): PartsField
labelClass(...class: null|string): PartsField
addLabelClass(...class: null|string): PartsField
label(content: null|string): PartsField
hintConfig(config: array): PartsField
hintAttributes(attributes: array): PartsField
addHintAttributes(attributes: array): PartsField
hintId(id: null|string): PartsField
hintClass(...class: null|string): PartsField
addHintClass(...class: null|string): PartsField
hint(content: null|string): PartsField
errorConfig(config: array): PartsField
errorAttributes(attributes: array): PartsField
addErrorAttributes(attributes: array): PartsField
errorId(id: null|string): PartsField
errorClass(...class: null|string): PartsField
addErrorClass(...class: null|string): PartsField
error(message: null|string, ...messages: string): PartsField
