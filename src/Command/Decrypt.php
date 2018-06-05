<?php
/**
 * test-util
 *
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Command;


use Crypt\EncoderInterface;
use Crypt\NewEncoderInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class Decrypt extends CommandAbstract
{

    protected function configure()
    {
        $this->setDescription('decrypt base64 package of data with key from key file');
        $this->addArgument('package', InputArgument::REQUIRED);
        $this->addArgument('algorithm', InputArgument::REQUIRED);
        $this->addArgument('keyfile', InputArgument::REQUIRED);
        $this->addArgument('privkeyfile', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $algorithm = $input->getArgument('algorithm');
        if (!in_array($algorithm, $this->supported)) {
            throw new \Exception('Unknown algorithm. Allowed [' . implode(',', $this->supported) . ']');
        }
        $package = $input->getArgument('package');
        $keyfile = $input->getArgument('keyfile');
        $privkeyfile = $input->getArgument('privkeyfile');

        $FQN = "Crypt\\${algorithm}";

        /** @var EncoderInterface $encoder */
        $encoder = new $FQN;
        if ($encoder instanceof NewEncoderInterface && !$privkeyfile) {
            throw new \Exception('private key file required');
        } elseif ($encoder instanceof NewEncoderInterface) {
            $encoder->setPrivateKey(file_get_contents($privkeyfile));
            $encoder->setPublicKey(file_get_contents($keyfile));
        } else {
            $encoder->setPrivateKey(file_get_contents($keyfile));
        }

        $result = base64_decode($package);
        if (!$result) {
            throw new RuntimeException('base64 decode error');
        }

        $result = $encoder->decrypt($result);

        if (!$result) {
            throw new RuntimeException('decryption error');
        }

        $style = new SymfonyStyle($input, $output);
        $style->section('Decrypted result');
        $style->text($result);
    }

}