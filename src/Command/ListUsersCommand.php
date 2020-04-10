<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * User Command Class that lists all existing users.
 * To use this command, open a terminal window, enter into your project directory
 * and execute the following:
 *
 *     $ php bin/console app:list-users
 *
 * See https://symfony.com/doc/current/cookbook/console/console_command.html
 *
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class ListUsersCommand extends Command
{
    /* A good practice is to use the 'app:' prefix
    to group all your custom application commands */

    /**
     * Command used in console.
     * @var string
     */
    protected static $defaultName = 'app:list-users';

    /** @var int */
    private const MAX_RESULT_DEFAULT_OPTION = 50;

    /**
     * All given users.
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Lists all the existing users')
            ->setHelp(
                'The <info>%command.name%</info> command lists all the users in DB :
                <info>php %command.full_name%</info>
                By default the command only displays the 50 most recent users.
                Set the number of
                results to display with the <comment>--max-results</comment> option:
                <info>php %command.full_name%</info> 
                <comment>--max-results=2000</comment>'
            )

            // commands can optionally define arguments and/or options (mandatory and optional)
            // see https://symfony.com/doc/current/components/console/console_arguments.html
            ->addOption(
                'max-results',
                null,
                InputOption::VALUE_OPTIONAL,
                'Limits the number of users listed',
                self::MAX_RESULT_DEFAULT_OPTION
            );
    }

    /**
     * This method is executed after initialize(). It contains the logic to execute.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $maxResults = $input->getOption('max-results');
        // Use ->findBy() instead of ->findAll() to allow result sorting and limiting
        $allUsers = $this->userRepository->findBy([], ['id' => 'DESC'], $maxResults);

        // Doctrine query returns an array of objects but we need an array of plain arrays
        $usersAsPlainArrays = array_map(
            static function (User $user) {
                return [
                    $user->getId(),
                    $user->getFirstName(),
                    $user->getEmail(),
                    implode(', ', $user->getRoles()),
                ];
            },
            $allUsers
        );

        // In your console commands you should always use the regular output type,
        // which outputs contents directly in the console window. However, this
        // command uses the BufferedOutput type instead, to be able to get the output
        // contents before displaying them.
        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io->table(
            ['ID', 'First Name', 'Email', 'Roles'],
            $usersAsPlainArrays
        );

        // Instead of just displaying the table of users,
        // store its contents in a variable
        $usersAsATable = $bufferedOutput->fetch();
        $output->write($usersAsATable);

        return 0;
    }
}
