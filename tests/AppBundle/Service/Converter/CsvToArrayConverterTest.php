<?php

namespace AppBundle\Service\Converter;

use AppBundle\Service\Converter\CsvToArrayConverter;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class CsvToArrayConverterTest extends \PHPUnit\Framework\TestCase
{
    public function testNoFile()
    {
        $this->expectException(FileNotFoundException::class);

        $filename = 'test-no-file.csv';

        $converter = new CsvToArrayConverter();
        $converter->convert($filename);
    }

    public function testEmptyFile()
    {
        $filename = __DIR__ . '/../../files/Service/Converter/empty-file.csv';

        $converter = new CsvToArrayConverter();
        $values = $converter->convert($filename);

        $this->assertEmpty($values);
    }

    public function testInvalidFile()
    {
        $filename = __DIR__ . '/../../files/Service/Converter/invalid-file.csv';

        $converter = new CsvToArrayConverter();
        $values = $converter->convert($filename);

        $this->assertEmpty($values);
    }

    public function testValidFile()
    {
        $filename = __DIR__ . '/../../files/Service/Converter/valid-file.csv';

        $converter = new CsvToArrayConverter();
        $values = $converter->convert($filename);

        $this->assertEquals('Test', $values[0]['name']);
        $this->assertEquals(23, $values[0]['age']);

        $this->assertEquals('NoName', $values[1]['name']);
        $this->assertEquals(101, $values[1]['age']);
    }
}
