<?php

// src/Command/CreateInfluencerCommand.php
namespace App\Command;

use App\Entity\Influencer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateInfluencerCommand extends Command
{
    protected static $defaultName = 'app:create-influencer';

    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->em = $em;
        $this->validator = $validator;
    }

    protected function configure()
    {
        $this->setDescription('Crea un nuevo influencer');
    }

    private function validateInputs(...$input): bool
    {
        foreach ($input as $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        print_r("\n <--  CREAR INFLUENCER  -->\n");

        $nameQuestion = new Question("\nNombre del influencer: ");
        $name = $helper->ask($input, $output, $nameQuestion);

        $emailQuestion = new Question("\nEmail: ");
        $email = $helper->ask($input, $output, $emailQuestion);

        $followersQuestion = new Question("\nCantidad de seguidores: ");
        $followersCount = $helper->ask($input, $output, $followersQuestion);
        $followersCount = $followersCount !== null ? (int)$followersCount : null;

        if (!$this->validateInputs($name, $email, $followersCount)) {
            $output->writeln('<error>Ingrese información en todos los campos obligatorios.</error>');
            return Command::FAILURE;
        }

        $influencer = new Influencer();
        $influencer->setName($name);
        $influencer->setEmail($email);
        $influencer->setFollowersCount($followersCount);

        $errors = $this->validator->validate($influencer);

        if (count($errors) > 0) {

            foreach ($errors as $error) {
                $output->writeln('<error>' . $error->getMessage() . '</error>');
            }

            $output->writeln('<info> Intente nuevamente </info>');

            return Command::FAILURE;
        }

        // $this->em->persist($influencer);
        // $this->em->flush();

        $output->writeln('Influencer creado con éxito! ID: ' . $influencer->getId());

        return Command::SUCCESS;
    }
}
