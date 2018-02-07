<?php
/**
 * test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

namespace Command;


use Symfony\Component\Console\Command\Command;

abstract class CommandAbstract extends Command
{
    protected $supported = ['RSA', 'SodiumCryptoBox'];


    public function __construct($name = null)
    {
        if ($name === null) {
            $name = strtolower((new \ReflectionObject($this))->getShortName());
        }
        parent::__construct($name);
    }


}