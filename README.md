verifyReddCoinAddress
=====================

PHP code to verify a ReddCoin wallet-address

Note: the bcmath PHP-extension is required.

##Usage (example):

```php
    <?php
        include('validator.class.php');
        $validator = new ReddCoinAddressValidator();
        $isValid = $validator->checkAddress("SOMEADDRESS");
        echo "isValid: " . ($isValid ? 'true' : 'false');
    ?>
```
