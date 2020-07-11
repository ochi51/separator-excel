<?php

namespace Ochi51\SeparatorExcel\Tests;

use Ochi51\SeparatorExcel\ImageDrawing;
use Ochi51\SeparatorExcel\InvalidImageDrawingException;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class ImageDrawingTest extends TestCase
{
    public function testContent()
    {
        $memoryDrawing = $this->createMemoryDrawingMock();
        $memoryDrawing
            ->method('getMimeType')
            ->willReturn(MemoryDrawing::MIMETYPE_PNG);

        $imageDrawing = new ImageDrawing($memoryDrawing);
        $this->assertEquals('test-content', $imageDrawing->getContent());
        $this->assertEquals('png', $imageDrawing->getExtension());
    }

    public function testPngExtension()
    {
        $memoryDrawing = $this->createMemoryDrawingMock();
        $memoryDrawing
            ->method('getMimeType')
            ->willReturn(MemoryDrawing::MIMETYPE_PNG);

        $imageDrawing = new ImageDrawing($memoryDrawing);
        $this->assertEquals('png', $imageDrawing->getExtension());
    }

    public function testJpegExtension()
    {
        $memoryDrawing = $this->createMemoryDrawingMock();
        $memoryDrawing
            ->method('getMimeType')
            ->willReturn(MemoryDrawing::MIMETYPE_JPEG);

        $imageDrawing = new ImageDrawing($memoryDrawing);
        $this->assertEquals('jpg', $imageDrawing->getExtension());
    }

    public function testGifExtension()
    {
        $memoryDrawing = $this->createMemoryDrawingMock();
        $memoryDrawing
            ->method('getMimeType')
            ->willReturn(MemoryDrawing::MIMETYPE_GIF);

        $imageDrawing = new ImageDrawing($memoryDrawing);
        $this->assertEquals('gif', $imageDrawing->getExtension());
    }

    public function testCsvExtension()
    {
        $memoryDrawing = $this->createMemoryDrawingMock();
        $memoryDrawing
            ->method('getMimeType')
            ->willReturn('text/csv');

        try {
            new ImageDrawing($memoryDrawing);
            $this->fail('InvalidImageDrawingException is not throw.');
        } catch (InvalidImageDrawingException $e) {
            $this->assertTrue(true);
        }
    }
    public function testFileContent()
    {
        $drawing = $this->createDrawingMock();

        $imageDrawing = new ImageDrawing($drawing);
        $this->assertEquals('test-content', $imageDrawing->getContent());
        $this->assertEquals('png', $imageDrawing->getExtension());
    }

    /**
     * @return MockObject|MemoryDrawing
     */
    private function createMemoryDrawingMock()
    {
        $mock = $this->getMockBuilder(MemoryDrawing::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->method('getRenderingFunction')->willReturn(self::class . '::content');
        $mock->method('getImageResource')->willReturn(null);

        return $mock;
    }

    public static function content()
    {
        echo 'test-content';
    }

    /**
     * @return MockObject|MemoryDrawing
     */
    private function createDrawingMock()
    {
        $mock = $this->getMockBuilder(Drawing::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file = __DIR__ . '/_data/test.txt';
        file_put_contents($file, 'test-content');
        $mock->method('getPath')->willReturn($file);
        $mock->method('getExtension')->willReturn('png');

        return $mock;
    }
}
