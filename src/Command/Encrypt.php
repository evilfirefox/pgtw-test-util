<?php
/**
 * test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

namespace Command;


use Crypt\EncoderInterface;
use Crypt\NewEncodersInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Encrypt extends CommandAbstract
{
    protected function configure()
    {
        $this->setDescription('encrypt package of data with key from key file, then base64 encode result');
        $this->addArgument('package', InputArgument::REQUIRED);
        $this->addArgument('keyfile', InputArgument::REQUIRED);
        $this->addArgument('privkeyfile', InputArgument::OPTIONAL);
        $this->addArgument('algorithm', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $algorithm = $input->getArgument('algorithm');
        if (!in_array($algorithm, $this->supported)) {
            throw new \Exception('Unknown algorithm. Allowed [' . implode(',', $this->supported) . ']');
        }


        $package = $input->getArgument('package');
        $pubkeyfile = $input->getArgument('keyfile');
        $privkeyfile = $input->getArgument('privkeyfile');
        $FQN = "Crypt\\${algorithm}";

        /** @var EncoderInterface $encoder */
        $encoder = new $FQN;
        $encoder->setPublicKey(file_get_contents($pubkeyfile));
        if ($encoder instanceof NewEncodersInterface && !$privkeyfile) {
            throw new \Exception('private key file required');
        } elseif ($encoder instanceof NewEncodersInterface) {
            $encoder->setPrivateKey(file_get_contents($privkeyfile));
        }
        $result = $encoder->encrypt($package);
        if ($result) {
            $result = base64_encode($result);
        } else {
            throw new RuntimeException('encryption error');
        }

        $style = new SymfonyStyle($input, $output);
        $style->section('Encrypted result');
        $style->text($result);
    }

}