<?php
/**
 * pgtw-test-util
 *
 * @author Serhii Borodai <serhii.borodai@globalgames.net>
 */

namespace Command;


use Crypt\SodiumCryptoBox;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAccount extends CommandAbstract
{
    protected  $pattern = '{"paymentSystem":"dmarket.internal","currencyList":["DMC","USD"],"credentials":{"uuid":"%s","hash":"%s","keyIdent":"%s","email":"%s"}}';


    protected function configure()
    {
        $this->setDescription('create DMarket user accounts');
        $this->addArgument('uuid', InputArgument::REQUIRED);
        $this->addArgument('hash', InputArgument::REQUIRED);
        $this->addArgument('keyIdent', InputArgument::REQUIRED);
        $this->addArgument('email', InputArgument::REQUIRED);

        $this->addArgument('pubkey', InputArgument::REQUIRED);
        $this->addArgument('privkey', InputArgument::REQUIRED);

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $uuid = $input->getArgument('uuid');
        $hash = $input->getArgument('hash');
        $keyIdent = $input->getArgument('keyIdent');
        $email = $input->getArgument('email');

        $encoder = new SodiumCryptoBox();
        $encoder->setPublicKey(file_get_contents($input->getArgument('pubkey')));
        $encoder->setPrivateKey(file_get_contents($input->getArgument('privkey')));

        $style = new SymfonyStyle($input, $output);
        $style->section('Prepared package');

        $message = sprintf($this->pattern, $uuid, $hash, $keyIdent, $email);

        $style->text($message);

        if (!json_decode($message)) {
            $style->section('Error');
            $style->error(json_last_error_msg());
            $style->comment($message);
        }

        $style->section('Encrypted package');
        $style->text(
            base64_encode(
                $encoder->encrypt($message)
            )
        );

    }

}