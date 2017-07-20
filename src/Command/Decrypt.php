<?php
/**
 * test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

namespace Command;


use phpseclib\Crypt\RSA;
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
        $this->addArgument('keyfile', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $package = $input->getArgument('package');
        $keyfile = $input->getArgument('keyfile');

        $encoder = new RSA();
        $encoder->loadKey(file_get_contents($keyfile));
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