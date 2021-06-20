# Simplicity I18n
A library for internationalization.

## Install
**composer**
```php 
composer require mmdm/sim-i18n
```

Or you can simply download zip file from github and extract it, 
then put file to your project library and use it like other libraries.

Just add line below to autoload files:

```php
require_once 'path_to_library/autoloader.php';
```

and you are good to go.

## How to use
```php
// to instantiate a translate object
$translate = new translate();

// then you should set directory and file of language
$translate->setTranslateDir('path_to_languages_directory');
$translate->setLocale(ISOLanguageCodes::LANGUAGE_ENGLISH);

// then use methods
$translate->translate($translate_key);
```

#### Description

It provides two kind of translate class:

- Simple instantiatable translate class
- Singleton instantiatable translate class

Both have same method but in different usage

1. If you use DIC (Dependency Injection Container) or can 
pass translate instance to other part of your application, 
then use simple one.
2. Otherwise use singleton for convenient.

**First one is recommended**

For language, it recommend *ISO 639-1* language codes that can 
access to them through `ISOLanguageCodes` class.

Test beside testing purposes, also have example purposes. See 
how to use methods there.

## Available functions

#### Translate

#### `createLanguageFile(string $language, string $directory)`

This method will create an empty language file in $directory.

Note: $language should be just the file name like en, fr etc.
Note: If directory or file is exists, it do nothing.
Note: Please use `ISOLanguageCodes` class for better results.

```php
// to create a language file
// de -> German
$translate->createLanguageFile('de', 'path/to/languages/directory');

// this is better
$translate->createLanguageFile(ISOLanguageCodes::LANGUAGE_GERMAN, 'path/to/languages/directory');
```

#### `setLocale(string $language)`

Set locale language to get translates from that file

Note: This is actually the language file name(Just file 
name not directory name).

Default is *en*

```php
// set locale to french
$translate->setLocale('fr');

// this is better
$translate->setLocale(ISOLanguageCodes::LANGUAGE_FRENCH);
```

#### `getLanguage(): string`

Get translate language that has been set from `setLocale` method.

Note: If you use *ISO 639-1* standard, you can set html language with 
this method easily.

```php
$language = $translate->getLanguage();
```

#### `setTranslateDir(string $directory)`

Set language directory

Note: Just specify directory not file.

```php
$translate->setTranslateDir('path_to_languages_directory');
```

#### `getTranslateFromFile(string $filename, bool $fresh = false): array`

Get all translates from a language file.

Basically after reading a language file, it will be cached by library 
but if you need to read it another time, pass *true* as $fresh 
variable value.

#### `itIsRTL()`

You can specify it is a *rtl* language that is using. Purpose of 
this method is to have specific reaction according to *rtl* in 
your view.

```php
$translate->itIsRTL();
```

#### `isRTL(): bool`

Return *true* if language is *rtl* otherwise return *false*.

Note: By default it will check in `ISOLanguageCodes` class in 
rtl languages to check it is a rtl language or not.
Note: If you set it is a rtl language through `itIsRTL` method, it 
will be rtl in any condition even if it's not.

```php
$is_rtl = $translate->isRTL();
```

#### `translate(string $key, $fileOrValue = null, array $value = [])`

This is the main method to translate to language you specified.

$key is the key that sets in language file.

In *$fileOrValue* parameter you can pass translate filename 
(without specify directory) or directory + filename by adding 
`file:` prefix to string or if you are happy with previous setting, 
and need to pass values to translate string, pass it here instead of 
third parameter.

**Note:** If `$key` could not translate, `$key` will return.

#### `translateChoice(string $key, int $count, $fileOrValue = null, array $value = [])`

Exactly like translate method but you can pluralization on it.

##### Example 1

If your file has structure like this:

```
return [
    'current-lang' => 'Current language is: ',
    'greeting' => 'Hello dear <strong>{user}</strong>',
    'labels' => [
        'test' => 'This is a test.'
    ]
]
```

you can access a translate like:

```php
$current_lang = $translate->translate('current-lang');

// output:
// Current language is: 
```

You can use placeholder for your translates and replace that 
placeholder by passing and array of key(as placeholder) and value(as 
value of placeholder) through $value parameter.

```php
$greeting = $translate->translate('greeting', ['user' => 'MMDM']);

// output:
// Hello dear <strong>MMDM</strong>
```
If you need to access a multidimensional array inside you translate 
file, you can pass $key as a dot separated string to get what you want:

```php
$test_label = $translate->translate('labels.test');

// output:
// This is a test.
```

##### Example 2

If you have multiple files with some translations like:

`file number 1`:

```
return [
    'a1' => 'hello',
    'b1' => 'hi',
    'c1' => 'hi {user}'
]
```

`file number 2`:

```
return [
    'a2' => 'hello again',
    'b2' => 'hi again',
    'c2' => 'hi again {user}'
]
```

Now to use translation you can do following things:

```php
// simple usage when you configured directory and filename before
$translate->translate('a1');

// change them in runtime
// [this is not so much convenient!]
$translate
    ->setTranslateDir('direcoty_to_file_1_or_2')
    ->setLocale('en_or_other_languages')
    ->translate('a1_or_a2');
    
// above code with parameter
$translate
    ->setTranslateDir('direcoty_to_file_1_or_2')
    ->setLocale('en_or_other_languages')
    ->translate('c1_or_c2', ['user' => 'MMDM']);
    
//===================================================
    
// a convenient way to use above code
// with just change locale filename
$translate->translate('a1_or_a2', 'en_or_other_languages');

// above code with parameter
$translate->translate('c1_or_c2', 'en_or_other_languages', ['user' => 'MMDM']);
    
// a convenient way to use above code
// with changing directory + filename
$translate->translate('a1_or_a2', 'file:directory/en_or_other_languages');
```

##### Example 3

Assume we have below translation file:

```php
<?php

return [
    'choice' => '{0} none|{1} one|{2,} more than one ({count})',
];
```

now to get it according to number of items, call 
`translateChoice` method.

```php
echo $translate->translateChoice('choice', 4);

// more than one (4)
```

as you can see we did not pass `count` to translate but it could 
be used internally.

Also if you pass count as third or forth parameter, it'll be replaced 
by actual count.

```php
echo $translate->translateChoice('choice', 4, ['count' => 66]);

// more than one (66)
```

#### ISOLanguageCodes

#### `static isInLanguageCode(string $code): bool`

Check if language is in *ISO 639-1* languages or not.

```php
// it will return true
ISOLanguageCodes::isInLanguageCode(ISOLanguageCodes::LANGUAGE_CZECH);

// it will return false
// it is Persian-Farsi but in ISO 639-2 code
ISOLanguageCodes::isInLanguageCode('per');
```

#### `static isRtlLanguage(string $code): bool`

Check if a language is rtl or not.

Rtl language list for now are:

- Arabic
- Azerbaijani
- Divehi
- Hebrew
- Kurdish
- Pashto
- PersianFarsi
- Sindhi
- Urdu
- Uyghur
- Yiddish

```php
// it will return true
$is_rtl = ISOLanguageCodes::isRtlLanguage(ISOLanguageCodes::LANGUAGE_PERSIAN_FARSI);

// it will return false
$is_rtl = ISOLanguageCodes::isRtlLanguage(ISOLanguageCodes::LANGUAGE_ENGLISH);
```

# License
Under MIT license.