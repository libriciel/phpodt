<?php

declare(strict_types=1);

namespace PhpOdt\Tests\TestCase;

use PhpOdt\Odt;
use PhpOdt\Paragraph;
use PhpOdt\ParagraphStyle;
use PhpOdt\StyleConstants;

final class OdtTest extends AbstractTestCase
{
    public function testGetInstance(): void
    {
        $this->path = $this->getTempnam();
        $odt = Odt::getInstance(true, $this->path);

        $this->assertInstanceOf('PhpOdt\Odt', $odt);
        $this->assertFileExists($this->path);
        $this->assertEmpty(file_get_contents($this->path));
    }

    public function testOutput(): void
    {
        $this->path = $this->getTempnam();
        $odt = Odt::getInstance(true, $this->path);
        $odt->output();

        $this->assertFileExists($this->path);
        $this->assertSame('application/vnd.oasis.opendocument.text', mime_content_type($this->path));
    }

    public function testInsertBackgroundImages(): void
    {
        $this->path = $this->getTempnam();
        $odt = Odt::getInstance(true, $this->path);

        $stylePortrait = new ParagraphStyle('PortraitParagraphStyle', 'Portrait');
        $stylePortrait->setBreakAfter(StyleConstants::PAGE);

        $styleLandscape = new ParagraphStyle('LandscapeParagraphStyle', 'Landscape');
        $styleLandscape->setBreakBefore(StyleConstants::PAGE);

        $images = [
            [
                'name' => 'page_00001',
                'orientation' => 'portrait',
                'path' => $this->getFixture('portrait.png'),
            ],
            [
                'name' => 'page_00002',
                'orientation' => 'landscape',
                'path' => $this->getFixture('landscape.png'),
            ],
        ];

        foreach ($images as $image) {
            if ($image['orientation'] == 'landscape') {
                $paragraph = new Paragraph($styleLandscape);
                $paragraph->addImage($image['path'], '29.7cm', '21cm', true, $image['name'], 'paragraph');
            } else {
                $paragraph = new Paragraph($stylePortrait);
                $paragraph->addImage($image['path'], '21cm', '29.7cm', true, $image['name'], 'paragraph');
            }
        }

        $odt->output();

        $this->assertFileExists($this->path);
        $this->assertSame('application/zip', mime_content_type($this->path));
    }
}
