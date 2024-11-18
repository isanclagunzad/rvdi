<?php

namespace App\Services;

class TsvReaderService
{
    /**
     * Read data from a Tsv file
     *
     * @param string $filePath Path to the TSV file
     * @param boolean $skipFirstRow skips first row results
     * @return array
     */
    public function read(string $filePath): array
    {
        $data = [];
        $delimiter = "\t";

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }
}
