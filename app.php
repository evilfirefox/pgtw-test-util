<?php
/**
 * test-util
 *
 * @author Serhii Borodai <s.borodai@globalgames.net>
 */

use Command\Decrypt;
use Command\Encrypt;

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
    new Decrypt()
]);


$app->run(new Symfony\Component\Console\Input\ArgvInput(), new Symfony\Component\Console\Output\ConsoleOutput());