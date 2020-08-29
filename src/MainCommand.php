<?php

namespace Ochi51\SeparatorExcel;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

/**
 * @author ochi51 <ochiai07@gmail.com>
 */
final class MainCommand extends SingleCommandApplication
{
    public function __construct()
    {
        parent::__construct('Separator Excel');
        $this->setUp();
    }

    private function setUp()
    {
        $this
            ->setVersion('1.0.0') // Optional
            ->addArgument('input', InputArgument::REQUIRED, 'The input Excel file path.')
            ->addOption('output', 'o', InputArgument::OPTIONAL, 'The output CSV file path.', 'export.csv')
            ->addOption('binary', 'b', InputArgument::OPTIONAL, 'The export images directory path.', __DIR__.'/../_output')
            ->setCode(
                function (InputInterface $input, OutputInterface $output) {
                    $excelPath = $input->getArgument('input');
                    if (!file_exists($excelPath)) {
                        $output->writeln('The input excel path is invalid.');

                        return Command::FAILURE;
                    }
                    $imageDir = $input->getOption('binary');
                    if (!file_exists($imageDir)) {
                        $output->writeln('The export images directory path is invalid.');

                        return Command::FAILURE;
                    }
                    $reader = new Xlsx();
                    $spreadsheet = $reader->load($excelPath);
                    $sheet = $spreadsheet->getActiveSheet();

                    $i = 0;
                    foreach ($sheet->getDrawingCollection() as $drawing) {
                        try {
                            $imageDrawing = new ImageDrawing($drawing);
                        } catch (InvalidImageDrawingException $e) {
                            continue;
                        }
                        $imageContents = $imageDrawing->getContent();
                        $extension = $imageDrawing->getExtension();
                        $file = 'image'.++$i.'.'.$extension;
                        $output->writeln('Export image: ' . $file);
                        $filename = $imageDir.'/'.$file;
                        file_put_contents($filename, $imageContents);

                        $sheet->setCellValue($drawing->getCoordinates(), $file);
                    }

                    $csvPath = $input->getOption('output');
                    $writer = new Csv($spreadsheet);
                    $writer->save($csvPath);

                    return Command::SUCCESS;
                }
            );
    }
}
