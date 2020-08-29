<?php

namespace Ochi51\SeparatorExcel\Tests;

use Exception;
use Ochi51\SeparatorExcel\MainCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class MainCommandTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test()
    {
        $outputCsv = __DIR__ . '/_output/export.csv';
        $imageDir = __DIR__ . '/_output';
        $command = new MainCommand();
        $command->setAutoExit(false);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'input' => __DIR__ . '/_data/test.xlsx',
            '--output' => $outputCsv,
            '--binary' => $imageDir
        ]);
        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        self::assertFileEquals(__DIR__ . '/_data/export.csv', $outputCsv);
        self::assertFileExists($imageDir . '/image1.png');
        self::assertFileExists($imageDir . '/image2.png');
        self::assertFileNotExists($imageDir . '/image3.png');
    }
}
