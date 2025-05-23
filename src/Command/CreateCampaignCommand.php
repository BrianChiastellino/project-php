<?php

namespace App\Command;

use App\Entity\Campaign;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCampaignCommand extends Command
{
    protected static $defaultName = 'app:create-campaign';

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
        $this->setDescription('Crea una nueva campaña');
    }

    private function isDateInExactFormat(string $input, string $expectedFormat = 'Y-m-d'): bool
    {
        $date = \DateTime::createFromFormat($expectedFormat, $input);

        return $date && $date->format($expectedFormat) === $input;
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

        print_r("\nCREACION DE CAMPAÑA - INGRESE SUS DATOS \n");

        $nameQuestion = new Question("\nIngrese nombre de la campaña: ");
        $name = $helper->ask($input, $output, $nameQuestion);

        $descQuestion = new Question("Ingrese una descripcion para '$name' - (Opcional): ");
        $description = $helper->ask($input, $output, $descQuestion);

        $startDateQuestion = new Question("Fecha inicio de campaña '$name' - (YYYY-MM-DD): ");
        $startDateInput = $helper->ask($input, $output, $startDateQuestion);
        $startDate = $startDateInput ? new \DateTime($startDateInput) : null;

        $endDateQuestion = new Question("Fecha fin de campaña '$name' - (YYYY-MM-DD): ");
        $endDateInput = $helper->ask($input, $output, $endDateQuestion);
        $endDate = $endDateInput ? new \DateTime($endDateInput) : null;

        if (!$this->validateInputs($name, $startDateInput, $endDateInput)) {
            $output->writeln('<error>Ingrese información en todos los campos obligatorios.</error>');
            return Command::FAILURE;
        }

        $campaign = new Campaign();
        $campaign->setName($name);
        $campaign->setDescription($description);
        $campaign->setStartDate($startDate);
        $campaign->setEndDate($endDate);

        $errors = $this->validator->validate($campaign);

        if (count($errors) > 0) {

            foreach ($errors as $error) {
                $output->writeln('<error>' . $error->getMessage() . '</error>');
            }

            $output->writeln('<info> Intente nuevamente </info>');

            return Command::FAILURE;
        }

        if (!$this->isDateInExactFormat($startDateInput) || !$this->isDateInExactFormat($endDateInput)) {

            $output->writeln('<error> El formato de fecha es incorrecto (YYYY-MM-DD) </error>');
            $output->writeln('<info> Intente nuevamente </info>');

            return Command::FAILURE;
        };


        // Guardar en BD

        $this->em->persist($campaign);
        $this->em->flush();

        $output->writeln("\nCampaña --> " . $campaign->getName() . " <-- creada con exito!\n");


        return Command::SUCCESS;
    }
}
