<?php

namespace App\Command;

use App\Entity\Influencer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListInfluencerCommand extends Command
{
    // Nombre del comando
    protected static $defaultName = 'app:list-influencers';

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this->setDescription('Lista todos los influencers registrados en la base de datos');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->em->getRepository(Influencer::class);
        $influencers = $repository->findAll();

        if (empty($influencers)) {
            $output->writeln('<comment>No hay influencers registrados.</comment>');
            return Command::SUCCESS;
        }

        print_r("\n <--  LISTADO DE INFLUENCERS  -->\n");


        foreach ($influencers as $influencer) {
            $output->writeln(sprintf(
                "\nID: %d \nNombre: %s \nEmail: %s \nFollowers: %d \nCampaña: %s",
                $influencer->getId(),
                $influencer->getName(),
                $influencer->getEmail() ?? 'N/A',
                $influencer->getFollowersCount(),
                $influencer->getCampaignInfo() ?? 'Sin camapaña asignada'
            ));
        }

        print_r("\n <--  FIN LISTADO DE INFLUENCERS  -->\n");




        return Command::SUCCESS;
    }
}
