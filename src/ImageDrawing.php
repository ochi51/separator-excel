<?php

namespace Ochi51\SeparatorExcel;

use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

/**
 * @author ochi51 <ochiai07@gmail.com>
 */
final class ImageDrawing
{
    /**
     * @var BaseDrawing
     */
    private $drawing;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $extension;

    /**
     * ImageDrawing constructor.
     * @param BaseDrawing $drawing
     */
    public function __construct(BaseDrawing $drawing)
    {
        $this->drawing = $drawing;

        $this->setUp();
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @throws InvalidImageDrawingException
     */
    private function setUp()
    {
        $drawing = $this->drawing;
        if ($drawing instanceof MemoryDrawing) {
            ob_start();
            call_user_func(
                $drawing->getRenderingFunction(),
                $drawing->getImageResource()
            );
            $this->content = ob_get_contents();
            ob_end_clean();
            switch ($drawing->getMimeType()) {
                case MemoryDrawing::MIMETYPE_PNG :
                    $this->extension = 'png';
                    break;
                case MemoryDrawing::MIMETYPE_GIF:
                    $this->extension = 'gif';
                    break;
                case MemoryDrawing::MIMETYPE_JPEG :
                    $this->extension = 'jpg';
                    break;
                default:
                    throw new InvalidImageDrawingException();
            }
        } else {
            $zipReader = fopen($drawing->getPath(), 'rb');
            $this->content = '';
            while (!feof($zipReader)) {
                $this->content .= fread($zipReader, 1024);
            }
            fclose($zipReader);
            $this->extension = $drawing->getExtension();
        }
    }
}
