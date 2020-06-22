# Contao Encryption

A replacement service for the removed Contao encryption class.

## DCA Example
```php
// tl_member
$GLOBALS['TL_DCA']['tl_member']['fields']['bank_iban'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_member']['bank_iban'],
    'exclude'           => true,
    'inputType'         => 'text',
    'eval'              => [
        'mandatory' => false,
        'maxlength' => 32,
        'tl_class' => 'w50',
        'feEditable' => true,
        'feGroup' => 'bank'
    ],
    'load_callback' => [
        ['brkwsky.jobs.helper.encryption', 'decrypt']
    ],
    'save_callback' => [
        ['brkwsky.jobs.helper.encryption', 'encrypt']
    ],
    'sql'               => "varchar(32) NOT NULL default ''"
];
```
