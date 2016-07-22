<?php

namespace Test\Bundle\CompanyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CsvReader;

/**
 * Description of ImportCsvCommand
 *
 * @author lubomir.ferenc
 */
class ImportCsvCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
                ->setName('import:csv')
                ->setDescription('Import data from CSV')
                ->addArgument(
                        'filename', InputArgument::REQUIRED, 'Insert path of csv file.'
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');

        $text = 'Reading ' . $filename . ' file... ';

        $output->writeln($text);

        $rowsInserted = $this->readCsvFile($filename);
        $output->writeln($rowsInserted . ' items was added.');

        $output->writeln('Import finished.');
    }

    /**
     * 
     * @param string $filename
     * @return int $rowsInserted
     */
    private function readCsvFile($filename)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $rows = [];

        if (($handle = fopen($filename, "r")) !== FALSE) {
            $headers = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== FALSE) {
                $rows[] = array_combine($headers, $row);
            }
        }

        $rowsInserted = $em->getRepository('TestCompanyBundle:Company')->insertCompanies($rows);

        return $rowsInserted;
    }

}
