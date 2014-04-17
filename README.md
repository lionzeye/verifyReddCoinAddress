verifyReddCoinAddress
=====================

PHP code to verify a ReddCoin wallet-address

Note: the bcmath PHP-extension is required.

##Usage (example):

```php
    $isValid = checkAddress("SOMEADDRESS");
    echo "isValid: " . ($isValid ? 'true' : 'false');
```
