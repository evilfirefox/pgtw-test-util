<?php
/**
 * Copyright Serhii Borodai (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Command;


use Crypt\SodiumCryptoBox;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Pay extends CommandAbstract
{
    protected  $pattern = '{"paymentSystem":"dmarket.internal","currency":"DMC","amount":"%s","comment":"payment for user %s","credentials":{"uuid":"%s"}}';


    protected function configure()
    {
        $this->setDescription('pay amount of DMC to uuid ');
        $this->addArgument('uuid', InputArgument::REQUIRED);
        $this->addArgument('amount', InputArgument::REQUIRED);
        $this->addArgument('pubkey', InputArgument::REQUIRED);
        $this->addArgument('privkey', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $uuid = $input->getArgument('uuid');
        $amount = $input->getArgument('amount');



        $encoder = new SodiumCryptoBox();
        $encoder->setPublicKey(file_get_contents($input->getArgument('pubkey')));
        $encoder->setPrivateKey(file_get_contents($input->getArgument('privkey')));

        $style = new SymfonyStyle($input, $output);
        $style->section('Prepared package');
        $style->text(sprintf($this->pattern, $amount, $uuid, $uuid));

        if (!json_decode(sprintf($this->pattern, $amount, $uuid, $uuid))) {
            $style->section('Error');
            $style->error(json_last_error_msg());
            $style->comment(sprintf($this->pattern, $amount, $uuid, $uuid));
        }

        $style->section('Encrypted package');
        $style->text(
            base64_encode(
                $encoder->encrypt(sprintf($this->pattern, $amount, $uuid, $uuid))
            )
        );

    }

}