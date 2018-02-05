<?php
/**
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Crypt;


class SodiumSealBox implements EncoderInterface
{


    protected $publicKey;
    protected $privateKey;

    /**
     * @return string $key hex representation of key @see sodium_bin2hex/sodium_hex2bin
     */
    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    /**
     * @return string $key hex representation of key @see sodium_bin2hex/sodium_hex2bin
     */
    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    /**
     * @param string $key hex representation of key @see sodium_bin2hex/sodium_hex2bin
     */
    public function setPublicKey($key)
    {
        $this->publicKey = $key;
    }

    /**
     * @param string $key hex representation of key @see sodium_bin2hex/sodium_hex2bin
     */
    public function setPrivateKey($key)
    {
        $this->privateKey = $key;
    }

    public function encrypt($data): string
    {
        return sodium_crypto_box_seal($data, sodium_hex2bin($this->getPublicKey()));
    }

    public function decrypt($cipher): string
    {
        return sodium_crypto_box_seal_open($cipher,
            sodium_crypto_box_keypair_from_secretkey_and_publickey(sodium_hex2bin($this->getPrivateKey()),
            sodium_crypto_box_publickey_from_secretkey(sodium_hex2bin($this->getPrivateKey())))
        );
    }

    public function createKeypair(): array
    {
        $keyPair = sodium_crypto_box_keypair();
        $result = [
            self::PRIVATE_KEY_STORE => sodium_bin2hex(sodium_crypto_box_secretkey($keyPair)),
            self::PUBLIC_KEY_STORE => sodium_bin2hex(sodium_crypto_box_publickey($keyPair))
        ];

        return $result;
    }
}