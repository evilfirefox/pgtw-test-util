<?php
/**
 * test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

use Command\Balance;
use Command\Decrypt;
use Command\Encrypt;
use Command\Keys;
use Command\Pay;

require 'vendor/autoload.php';

class App extends \Symfony\Component\Console\Application
{
    public function getName()
    {
        return "PGTW test helpers";
    }

}

$app = new App();

$app->addCommands([
    new Encrypt(),
    new Decrypt(),
    new Keys(),
    new Pay(),
    new Balance(),
]);


$app->run(new Symfony\Component\Console\Input\ArgvInput(), new Symfony\Component\Console\Output\ConsoleOutput());