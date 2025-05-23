<?php

namespace App\Command;

use App\Entity\Campaign;
use App\Entity\Influencer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:assign-influencer',
    description: 'Asignar influencer a una camapaña',
)]
class AssignInfluencerCommand extends Command
{

    protected static $defaultName = 'app:assign-influencer';


    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Asigna un influencer a una campaña (relación 1:N)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $helper = $this->getHelper('question');

        $influencers = $this->em->getRepository(Influencer::class)->findAll();
        
        if (empty($influencers)) {
            $output->writeln('<error>No hay influencers en el sistema.</error>');
            return Command::FAILURE;
        }

        print_r("\n <--  LISTADO DE INFLUCNERES  --> \n");

        foreach( $influencers as $influencer ) {
            $output->writeln("ID: " . $influencer->getId() . " | Nombre " . $influencer->getName());
        }


        $influencerIdQuestion = new Question("\nIngrese el ID del influencer: ");
        $influencerId = $helper->ask($input, $output, $influencerIdQuestion);
        $influencerId = $influencerId !== null ? (int)$influencerId : null;

        $campaigns = $this->em->getRepository(Campaign::class)->findAll();

        if (empty($campaigns)) {
            $output->writeln('<error>No hay campañas en el sistema.</error>');
            return Command::FAILURE;
        }

        print_r("\n <--  LISTADO DE CAMPAÑAS  --> \n");

        foreach ($campaigns as $campaign) {
            $output->writeln("ID: " . $campaign->getId() . " | Nombre: " . $campaign->getName());
        }

        $campaignIdQuestion = new Question("\nIngrese el ID de la campaña: ");
        $campaignId = $helper->ask($input, $output, $campaignIdQuestion);
        $campaignId = $campaignId !== null ? (int)$campaignId : null;
        


        $influencer = $this->em->getRepository(Influencer::class)->find($influencerId);
        $campaign = $this->em->getRepository(Campaign::class)->find($campaignId);

        if (!$influencer || !$campaign) {
            $output->writeln('<error>Influencer o campaña no encontrados.</error>');
            return Command::FAILURE;
        }

        $influencer->setCampaign($campaign);
        $this->em->flush();

        $output->writeln("<info>Influencer #$influencerId asignado a campaña #$campaignId.</info>");
        return Command::SUCCESS;
    }
}
