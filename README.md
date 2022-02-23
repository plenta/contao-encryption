![](https://github.com/Brkwsky/contao-encryption/workflows/PHP%20Unit%20and%20Security%20Check/badge.svg)

# Contao Encryption

A replacement service for the deprecated Contao encryption class (Contao\Encryption).  
Please set an encryption key before using the dca callbacks or encryption services.

## Install using Contao Manager

Search for **encryption** and you will find this extension.

## Install using Composer

```bash
composer require plenta/contao-encryption
```

## Encryption Key
**Please read this thoroughly otherwise you might lose all your encrypted data!**

This extension uses the standard encryption key `%kernel.secret%` as default. Symfony recommends changing the `%kernel.secret%` periodically. Therefore, it is highly recommended setting a dedicated encryption key for this extension.

### How to set a dedicated encryption key
The config parameter is called `encryption_key` and it lives under the namespace `plenta_conta_encryption`.
Its value should be a series of characters, numbers and symbols chosen randomly and the recommended length is around 32 characters.

Keep a backup of your encryption key. If you lose it you can not recover your data.  
If you want to change the encryption key, you have to decrypt all your encrypted data with the old encryption key and then encrypt it with the new one.

```yaml
# config/parameters.yaml or config/services.yaml

plenta_contao_encryption:
    encryption_key: 'CharactersNumbersSymbolsAround32CharactersLong'
```

You can also use environment variables.
```yaml
# config/parameters.yaml or config/services.yaml

plenta_contao_encryption:
    encryption_key: '%env(PLENTA_CONTAO_ENCRYPTION_KEY)%'
```

```dotenv
# .env or .env.local
PLENTA_CONTAO_ENCRYPTION_KEY="CharactersNumbersSymbolsAround32CharactersLong"
```

## Example > DCA
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
$urlParameter = $encryptionService->encryptUrlSafe('value');

$urlGetParameter = \Contao\Input::get('parameter');
$encryptionService->decryptUrlSafe($urlGetParameter);
```
