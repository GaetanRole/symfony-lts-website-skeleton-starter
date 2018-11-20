<?php

/**
 * User Command File
 *
 * PHP Version 7.2
 *
 * @category Command
 * @package  User
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

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
 * For more advanced uses, commands can be defined as services too. See
 * https://symfony.com/doc/current/console/commands_as_services.html
 *
 * @category Command
 * @package  User
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class ListUsersCommand extends Command
{
    // a good practice is to use the 'app:' prefix
    // to group all your custom application commands
    /**
     * Command used in console
     *
     * @var string
     */
    protected static $defaultName = 'app:list-users';

    /**
     * All given users
     *
     * @var UserRepository
     */
    private $_users;

    /**
     * ListUsersCommand constructor.
     *
     * @param UserRepository $users Given entity
     */
    public function __construct(UserRepository $users)
    {
        parent::__construct();

        $this->_users = $users;
    }

    /**
     * {@inheritdoc}
     *
     * @return void
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

            // commands can optionally define arguments
            // and/or options (mandatory and optional)
            // see https://symfony.com/doc/current/components/console/console_arguments.html
            ->addOption(
                'max-results',
                null,
                InputOption::VALUE_OPTIONAL,
                'Limits the number of users listed',
                50
            );
    }


    /**
     * This method is executed after initialize(). It usually contains the logic
     * to execute to complete this command task.
     *
     * @param InputInterface  $input  Command option
     * @param OutputInterface $output Standard print
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $maxResults = $input->getOption('max-results');
        // Use ->findBy() instead of ->findAll() to allow result sorting and limiting
        $allUsers = $this->_users->findBy([], ['id' => 'DESC'], $maxResults);

        // Doctrine query returns an array of objects
        // and we need an array of plain arrays
        $usersAsPlainArrays = array_map(
            function (User $user) {
                return [
                    $user->getId(),
                    $user->getFirstName(),
                    $user->getEmail(),
                    implode(', ', $user->getRoles()),
                ];
            }, $allUsers
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

        // instead of just displaying the table of users,
        // store its contents in a variable
        $usersAsATable = $bufferedOutput->fetch();
        $output->write($usersAsATable);
    }
}
