<?php
/**
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Crypt;


interface EncoderInterface
{
    const PRIVATE_KEY_STORE = 'privatekey';
    const PUBLIC_KEY_STORE  = 'publickey';

    public function getPublicKey(): ?string;
    public function getPrivateKey(): ?string;
    public function setPublicKey($key);
    public function setPrivateKey($key);

    public function encrypt($data): string;
    public function decrypt($cipher): string;

    public function createKeypair(): array;
}

