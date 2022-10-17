<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Dumps the completion script for the current shell.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
#[AsCommand(name: 'completion', description: 'Dump the shell completion script')]
final class DumpCompletionCommand extends Command
{
    /**
     * @deprecated since Symfony 6.1
     */
    protected static $defaultName = 'completion';

    /**
     * @deprecated since Symfony 6.1
     */
    protected static $defaultDescription = 'Dump the shell completion script';

    private array $supportedShells;

    protected function configure()
    {
        $fullCommand = $_SERVER['PHP_SELF'];
        $commandName = basename($fullCommand);
        $fullCommand = @realpath($fullCommand) ?: $fullCommand;

        $shell = $this->guessShell();
        [$rcFile, $completionFile] = match ($shell) {
            'fish' => ['~/.config/fish/config.fish', "/etc/fish/completions/$commandName.fish"],
            default => ['~/.bashrc', "/etc/bash_completion.d/$commandName"],
        };

        $this
            ->setHelp(<<<EOH
The <info>%command.name%</> command dumps the shell completion script required
to use shell autocompletion (currently, bash and fish completion is supported).

<comment>Static installation
-------------------</>

Dump the script to a global completion file and restart your shell:

    <info>%command.full_name% {$shell} | sudo tee {$completionFile}</>

Or dump the script to a local file and source it:

    <info>%command.full_name% {$shell} > completion.sh</>

    <comment># source the file whenever you use the project</>
    <info>source completion.sh</>

    <comment># or add this line at the end of your "{$rcFile}" file:</>
    <info>source /path/to/completion.sh</>

<comment>Dynamic installation
--------------------</>

Add this to the end of your shell configuration file (e.g. <info>"{$rcFile}"</>):

    <info>eval "$({$fullCommand} completion {$shell})"</>
EOH
            )
            ->addArgument('shell', InputArgument::OPTIONAL, 'The shell type (e.g. "bash"), the value of the "$SHELL" env var will be used if this is not given', null, $this->getSupportedShells(...))
            ->addOption('debug', null, InputOption::VALUE_NONE, 'Tail the completion debug log')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $commandName = basename($_SERVER['argv'][0]);

        if ($input->getOption('debug')) {
            $this->tailDebugLog($commandName, $output);

            return self::SUCCESS;
        }

        $shell = $input->getArgument('shell') ?? self::guessShell();
        $completionFile = __DIR__.'/../Resources/completion.'.$shell;
        if (!file_exists($completionFile)) {
            $supportedShells = $this->getSupportedShells();

            ($output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output)
                ->writeln(sprintf('<error>Detected shell "%s", which is not supported by Symfony shell completion (supported shells: "%s").</>', $shell, implode('", "', $supportedShells)));

            return self::INVALID;
        }

        $output->write(str_replace(['{{ COMMAND_NAME }}', '{{ VERSION }}'], [$commandName, $this->getApplication()->getVersion()], file_get_contents($completionFile)));

        return self::SUCCESS;
    }

    private static function guessShell(): string
    {
        return basename($_SERVER['SHELL'] ?? '');
    }

    private function tailDebugLog(string $commandName, OutputInterface $output): void
    {
        $debugFile = sys_get_temp_dir().'/sf_'.$commandName.'.log';
        if (!file_exists($debugFile)) {
            touch($debugFile);
        }
        $process = new Process(['tail', '-f', $debugFile], null, null, null, 0);
        $process->run(function (string $type, string $line) use ($output): void {
            $output->write($line);
        });
    }

    /**
     * @return string[]
     */
    private function getSupportedShells(): array
    {
        return $this->supportedShells ??= array_map(function ($f) {
            return pathinfo($f, \PATHINFO_EXTENSION);
        }, glob(__DIR__.'/../Resources/completion.*'));
    }
}
