<?php 

namespace App\Command;

use App\Entity\Campaign;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCampaignsCommand extends Command
{
    protected static $defaultName = 'app:list-campaigns';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Lista todas las campañas existentes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->em->getRepository(Campaign::class);
        $campaigns = $repository->findAll();

        if (empty($campaigns)) {
            $output->writeln('No hay campañas registradas.');
            return Command::SUCCESS;
        }
        
        print_r("\n <--  LISTADO DE CAMPAÑAS  --> \n");

        foreach ($campaigns as $campaign) {
            $output->writeln(sprintf(
                "\n ID: %d \n Nombre: %s \n Descripcion: %s \n Inicio: %s \n Fin: %s \n",
                $campaign->getId(),
                $campaign->getName(),
                $campaign->getDescription() ?? 'No existe descripcion',
                $campaign->getStartDate()?->format('Y-m-d'),
                $campaign->getEndDate()?->format('Y-m-d')
            ));
        }

        print_r("\n <--  FIN LISTADO DE CAMAPAÑAS --> \n");


        return Command::SUCCESS;
    }
}

?>