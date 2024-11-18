<?php

namespace App\Services;

class CsvReaderService
{
    /**
     * Read data from a CSV file, skipping the first row (header).
     *
     * @param string $filePath Path to the CSV file
     * @param boolean $skipFirstRow skips first row results
     * @return array
     */
    public function readCSV(string $filePath, bool $skipFirstRow = false): array
    {
        $data = [];
        $hasPassedFirstRow = false;
        $delimiter = ',';

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (! $hasPassedFirstRow && $skipFirstRow) {
                    $hasPassedFirstRow = true;
                    continue; // Skip the first row (header)
                }
                
                $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }
}
