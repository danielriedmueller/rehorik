<?php

class ImportProductsCsv
{
    public function uploadFile()
    {

    }
    public function importByFile($file): void
    {
        $file = fopen($file, 'r');
        $header = fgetcsv($file, 0, ';');
        $products = [];
        while ($row = fgetcsv($file, 0, ';')) {
            $products[] = array_combine($header, $row);
        }
        fclose($file);
        $this->import($products);
    }

    private function import(array $products): void
    {
    }
}
