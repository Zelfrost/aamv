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
            if ($userData['usr_1'] === '') {
                $city = '';
            } else {
                $city = '';
                $results = [];
                preg_match('/^.+ - ([0-9]{5})/', $userData['usr_1'], $results);

                $postalCode = $results[1];

                try {
                    $cities = $this->getContainer()->get('retriever.city')->retrieve($postalCode);
                } catch (\Exception $e) {
                    var_dump($e->getMessage());

                    break;
                }

                $city = str_replace($postalCode . ' ', '', $cities[0]['id']);
            }

            if (substr_count($userData['name'], ' ') === 1) {
                $name = explode(' ', $userData['name'])[0];
                $firstName = explode(' ', $userData['name'])[1];
            } else {
                $name = $userData['name'];
                $firstName = '';
            }

            $user = new User();
            $user->setPassword('');
            $user->setRoles([$userData['usr_2']]);
            $user->setLegacyPassword($userData['legacy_password']);
            $user->setName($name);
            $user->setFirstname($firstName);
            $user->setCity($city);
            $user->setNeighborhood(null);
            $user->setPhoneNumber(null);
            $user->setEmail($userData['email']);

            $em->persist($user);
            $em->flush();

            $progress->advance();
        }

        $output->writeLn('');

    }
}
