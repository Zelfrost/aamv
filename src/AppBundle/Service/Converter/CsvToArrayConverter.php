<?php

namespace AppBundle\Service\Converter;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class CsvToArrayConverter
{
    public function convert($filename) 
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            throw new FileNotFoundException(null, 0, null, $filename);
        }
        
        $header = null;
        $data = array();
        
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, '|')) !== false) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }

            fclose($handle);
        }

        return $data;
    }
}
