<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportLegacyUsersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import_legacy_users')
            ->setDescription('Import each users from given file.')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'A csv file containing users'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $converter = $this->getContainer()->get('converter.csv_to_array');

        $data = $converter->convert(sprintf(
            __DIR__.'/../../../%s',
            $input->getArgument('file')
        ));

        $progress = new ProgressBar($output, count($data));
        $progress->start();

        foreach ($data as $userData) {
            $user = new User();
            $user->setUsername($userData['email']);
            $user->setPassword('');
            $user->setRoles(['ROLE_ASSISTANTE']);
            $user->setLegacyPassword($userData['legacy_password']);
            $user->setName($userData['name']);
            $user->setFirstname($userData['firstname']);
            $user->setCity('');
            $user->setNeighborhood(null);
            $user->setPhoneNumber(null);
            $user->setEmail($userData['email']);

            $em->persist($user);

            $progress->advance();
        }

        $em->flush();
    }
}
