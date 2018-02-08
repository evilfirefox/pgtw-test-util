<?php
/**
 * pgtw-test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

namespace Command;


use Crypt\EncoderInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class Keys extends CommandAbstract
{
    protected function configure()
    {
        $this->setDescription('generate key pair for algo');
        $this->addArgument('algorithm', InputArgument::REQUIRED);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $algorithm = $input->getArgument('algorithm');
        if (!in_array($algorithm, $this->supported)) {
            throw new \Exception('Unknown algorithm. Allowed [' . implode(',', $this->supported) . ']');
        }

        $FQN = "Crypt\\${algorithm}";
        /** @var EncoderInterface $encoder */
        $encoder = new $FQN;

        $result = $encoder->createKeypair();

        if (!$result) {
            throw new RuntimeException('decryption error');
        }
        unset($result['partialkey']);

        $style = new SymfonyStyle($input, $output);
        $style->section('Keypair');
        foreach ($result as $key => $item) {
            $style->success($key);
            $style->text($item);
        }
    }
}