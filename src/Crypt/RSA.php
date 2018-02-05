<?php
/**
 * @author Serhii Borodai <clarifying@gmail.com>
 */
namespace Crypt;

/**
 * Proxy class for phpseclib RSA
 * @author Serhii Borodai <clarifying@gmail.com>
 */
class RSA implements EncoderInterface
{
    /**
     * @var \phpseclib\Crypt\RSA
     */
    private $rsa;

    private $keySize;

    /**
     * RSA constructor.
     * @param int $keySize
     */
    public function __construct(int $keySize = 4096)
    {
        $this->rsa = new \phpseclib\Crypt\RSA();
        $this->keySize = $keySize;
    }

    public function getPublicKey(): ?string
    {
        return $this->rsa->getPublicKey() ? $this->rsa->getPublicKey() : null;
    }

    public function getPrivateKey(): ?string
    {
        return $this->rsa->getPrivateKey() ? $this->rsa->getPrivateKey() : null;
    }

    /**
     * @param $key
     * @throws \Exception
     */
    public function setPublicKey($key)
    {
        if (!$this->rsa->loadKey($key)) {
            throw new \Exception("can't load public key");
        }
    }

    /**
     * @param $key
     * @throws \Exception
     */
    public function setPrivateKey($key)
    {
        if (!$this->rsa->loadKey($key)) {
            throw new \Exception("can't load private key");
        }
    }

    public function encrypt($data): string
    {
        return $this->rsa->encrypt($data);
    }

    public function decrypt($cipher): string
    {
        return $this->rsa->decrypt($cipher);
    }


    public function createKeypair(): array
    {
        return $this->rsa->createKey($this->keySize);
    }
}