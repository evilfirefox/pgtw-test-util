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

class Encrypt extends CommandAbstract
{
    protected function configure()
    {
        $this->setDescription('encrypt package of data with key from key file, then base64 encode result');
        $this->addArgument('package', InputArgument::REQUIRED);
        $this->addArgument('keyfile', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $package = $input->getArgument('package');
        $keyfile = $input->getArgument('keyfile');

        $encoder = new RSA();
        $encoder->loadKey(file_get_contents($keyfile));
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