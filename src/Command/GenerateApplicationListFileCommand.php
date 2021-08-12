<?php

namespace App\Command;

use App\Entity\Application;
use Doctrine\DBAL\FetchMode;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class GenerateApplicationListFileCommand extends Command
{
    private const FILE_PATH = 'public/data.json';
    private const DEFAULT_COORDINATES = '55.331903, 37.111961';
    protected static $defaultName = 'app:application:file';

    protected ContainerBagInterface $containerBag;
    protected ManagerRegistry $doctrine;

    /**
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ContainerBagInterface $containerBag, ManagerRegistry $doctrine)
    {
        parent::__construct();
        $this->containerBag = $containerBag;
        $this->doctrine = $doctrine;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init data
        $filePath = $this->containerBag->get('kernel.project_dir').'/'.self::FILE_PATH;

        $output->writeln('Starting to generate applications list file.');
        $output->writeln('Output file: '.$filePath);

        // Start file
        $f = fopen($filePath, 'w+');
        fwrite($f, '{"type": "FeatureCollection", "features": [');

        $conn = $this->doctrine->getConnection();
        $prep = $conn->prepare("SELECT * FROM `application`;");
        $prep->execute();
        $prep->setFetchMode(FetchMode::CUSTOM_OBJECT, Application::class);//ToDo: replace deprecated approach
        $count = $prep->rowCount();
        $i=1;
        /** @var Application $application */
        while($application = $prep->fetch()){
            $id = $application->getId();
            $coordinates = self::DEFAULT_COORDINATES;
            $title = $application->getTitle();
            $last = $i===$count;
            fwrite($f, '{"type":"Feature","id":'.$id.',"geometry":{"type": "Point","coordinates": ['.$coordinates.']},"properties":{"balloonContent":"'.$title.'"}}'.($last?'':','));
            $i++;
        }

        // End file
        fwrite($f, ']}');
        fclose($f);
        $output->writeln('Written applications: '.($i-1));
        return Command::SUCCESS;
    }
}
