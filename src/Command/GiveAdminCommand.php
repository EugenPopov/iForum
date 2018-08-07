<?php

namespace App\Command;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class GiveAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:grant-admin-privileges')
            ->setDescription('Set user role to admin')
            ->setHelp('This command allows u to set user\'s role to "ROLE_ADMIN"');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $helper = $this->getHelper('question');
        $question = new Question('Please enter user ID : ');
        $bundleName = $helper->ask($input, $output, $question);
        $user = $em->getRepository(Users::class)->findOneBy(['id'=>$bundleName]);

        if (empty($user)) {
            $output->writeln('Such a user doesn\'t exist');

            return;
        }


        $userName = $user->getUserName();
        $confirm = new ConfirmationQuestion(
            "Did u mean $userName? ",
            false,
            '/(y|yes|yeah)/'
        );
        $confirmResult = $helper->ask($input, $output, $confirm);

        if (!$confirmResult) {
            $output->writeln('Canceled');

            return;
        }
        $user->setRoles(['ROLE_ADMIN']);
        $em->flush();
        $output->writeln('Role changed successfully');
    }
}
