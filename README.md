[![PHP 7.1](https://img.shields.io/badge/PHP-7.1-8892BF.svg)]() [![PHPCS PSR-12](https://img.shields.io/badge/PHPCS-PSR–12-226146.svg)](https://www.php-fig.org/psr/psr-12/) [![PHPUnit ](.github/coverage.svg)](https://brianhenryie.github.io/bh-php-monero-explorer/) [![PHPStan ](https://img.shields.io/badge/PHPStan-Level%208-2a5ea7.svg)](https://phpstan.org/)

## PHP Bitcoin Address

A simple P2PK, P2PKH, P2SH, P2WPKH, P2WSH, P2TR output script/address parser/generator/validator.

**Supported types:**

- Pay-To-PubKey (P2PK)
- Pay-To-PubKeyHash (P2PKH)
- Pay-To-Multisig (P2MS)
- Pay-To-ScriptHash (P2SH)
- Pay-To-WitnessPubKeyHash (P2WPKH)
- Pay-To-WitnessScriptHash (P2WSH)
- Pay-To-Taproot (P2TR)
- P2WPKH-over-P2SH
- P2WSH-over-P2SH
- any combination

**Supported networks:**

- Bitcoin
- Bitcoin Testnet
- Bitcoin Gold
- Bitcoin Cash
- Litecoin
- Litecoin Testnet
- Dogecoin
- Dogecoin Testnet
- Viacoin
- Viacoin Testnet
- Dash
- Dash Testnet
- Zcash

### Installation

```bash
composer require andkom/php-bitcoin-address
```

### Examples

Generate a P2PK/P2PKH address:

```php
$address = OutputFactory::p2pk($pubKey)->address(); 
$address = OutputFactory::p2pkh($pubKeyHash)->address(); 
```

Generate a P2MS address:

```php
$address = OutputFactory::p2ms(2, [$pubKey1, $pubKey2, $pubKey3])->address();
```

Generate a P2SH address:

```php
$factory = new OutputFactory();
$p2ms = $factory->p2ms(2, [$pubKey1, $pubKey2, $pubKey3]);
$address = $factory->p2sh($p2ms)->address();
```

Generate a P2WPKH address:

```php
$address = OutputFactory::p2wpkh($pubKeyHash)->address();
```

Generate a P2WSH address:

```php
$factory = new OutputFactory();
$p2ms = $factory->p2ms(2, [$pubKey1, $pubKey2, $pubKey3]);
$address = $factory->p2wsh($p2ms)->address();
```

Generate a P2WPKH-over-P2SH address:

```php
$factory = new OutputFactory();
$p2wpkh = $factory->p2wpkh($pubKeyHash);
$address = $factory->p2sh($p2wpkh)->address();
```

Generate a P2WSH-over-P2SH address:

```php
$factory = new OutputFactory();
$p2ms = $factory->p2ms(2, [$pubKey1, $pubKey2, $pubKey3]);
$p2wsh = $factory->p2wsh($p2ms);
$address = $factory->p2sh($p2wsh)->address();
```

Generate a P2TR address:

```php
$taprootPubKey = Taproot::construct($pubKey);
$address = OutputFactory::p2tr($taprootPubKey)->address();
```

Generate an address from an output script:

```php
$address = OutputFactory::fromScript($script)->address();
```

Decode a Bitcoin address:

```php
$output = NetworkFactory::bitcoin()->decodeAddress('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH');
```

Get a Bitcoin address type:

```php
$type = NetworkFactory::bitcoin()->decodeAddress('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH')->type(); // p2pkh
```

Validate a Bitcoin address:

```php
NetworkFactory::bitcoin()->validateAddress('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH'); // true
```