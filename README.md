# Contao Encryption

A replacement service for the removed Contao encryption class.

## DCA Example
```php
// tl_member
$GLOBALS['TL_DCA']['tl_member']['fields']['bank_iban'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_member']['bank_iban'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'mandatory' => false,
        'maxlength' => 32,
        'tl_class' => 'w50',
        'feEditable' => true,
        'feGroup' => 'bank'
    ],
    'load_callback' => [
        ['brkwsky.encryption', 'decrypt']
    ],
    'save_callback' => [
        ['brkwsky.encryption', 'encrypt']
    ],
    'sql' => "varchar(32) NOT NULL default ''"
];
```

## Example > Url parameter

```php
$encryptionService = \Contao\System::getContainer()->get('brkwsky.encryption');
$urlParamter = $encryptionService->encryptUrlSafe('value');

$urlGetParameter = \Contao\Input::get('parameter');
$encryptionService->decryptUrlSafe($urlGetParameter);
```
