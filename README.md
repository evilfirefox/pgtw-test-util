**utils for testing pgtw**

1. Install PHP
2. Install composer
https://getcomposer.org/doc/00-intro.md


```
git clone https://github.com/sfortop/pgtw-test-util.git source_dir
cd source_dir
composer install
```

Run to get short help
```
bin\pgtw 
```

How to use

```
cd source_dir
bin\pgtw - PGTW test helpers

Examples:
bin\pgtw encrypt {"uuid":"96d4ec61-7f28-4a15-883b-9b100b618e26"} RSA skins_pub.pub
bin\pgtw decrypt BM4j9ZD/Gde7Y93efOZRVV/DB2eNg+IWIP442/byPA/Y6QrxMQWJZXjxj53nR8uwQSOShr2ObAL4pnCpVfNB4JkrCx/pABDjDGtW5ZL6QHCmybksIene93oD8DNk1PKu62HNchWR/OhfNWIpWSYGHDBM1i2oo10peKXXQULz8/ix7paiRXucuW2wv8jTI6ZC67LdY8ZUa8frOIbF+MBEhPZca12dSceGS92ZAD4wUqorWKii2Sbzb2TQwYEMH7SD7eU2vMg4xK1GAvbafwSHOm8SZYS04UF9vBZAwBKTVkYWNd47laar59s8iqR7RkiPpfNepWqpr7DmKmWefgo6zw8k0MPGSs7+nGn5SvWM1BGukMvKdZsB6VpDpTlyL+zwggwcakd+AihqXHmUkrZKrA9C5xmW23771j/X8LsSg5iT22cMHBfbfeSaUMOrMEfeD+1x+ETIhqPcnOU2bu60zswO1XOkMk7OY884SeLi4XnJf1aqPQKxlkImhVByaBsBmZej5f9VODLBC55eUAE5HK2y2z0O0gf5FE3QyauLgHE02St6mpUgyOkXDOMOizeku1lf5efwnMwP7Je50WzWOJ9VweRZlHcgaWfzZ0aoEtgpOHPjEbgHAg9fodhKa2aPNR86PK/X3Mw2/v1cnCAmJLXGqzMD21+I87bVZRpgKNY=  skins_pub.pub


encryption with public key (pub)
decription with privat key (sec)
```

For Sodium

```
bin\pgtw encrypt "some json" SodiumCryptoBox pubkey privkey
```
