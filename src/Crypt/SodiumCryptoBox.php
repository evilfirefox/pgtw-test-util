<?php
/**
 * pgtw-test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

namespace Crypt;

/**
 * Class SodiumCryptoBox
 * @package Crypt
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */
class SodiumCryptoBox implements EncoderInterface, NewEncoderInterface
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

    /**
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function encrypt($data): string
    {
        return sodium_crypto_box(
            $data,
            random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES),
            $this->getKeypairFromSecretPublicKeys()
        );
    }

    public function decrypt($cipher): string
    {
        $nonce = substr($cipher, 0, SODIUM_CRYPTO_BOX_NONCEBYTES);
        $msg = substr($cipher, SODIUM_CRYPTO_BOX_NONCEBYTES);

        return sodium_crypto_box_open($msg, $nonce, $this->getKeypairFromSecretPublicKeys());

    }

    public function getKeypairFromSecretPublicKeys()
    {
        $keypair = sodium_crypto_box_keypair_from_secretkey_and_publickey(
            $this->getPrivateKey(),
            $this->getPublicKey()
        );
        return $keypair;
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