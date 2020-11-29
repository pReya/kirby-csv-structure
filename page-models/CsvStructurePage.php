<?php

use League\Csv\Reader;
use League\Csv\Writer;

class CsvStructurePage extends Kirby\Cms\Page
{
  public function content(string $languageCode = null)
  {

    $reader = Reader::createFromPath($this->root() . option('preya.kirby-csv-structure.csvFileName'), 'r');
    $reader->setDelimiter(option('preya.kirby-csv-structure.delimiter'));

    
    if (count($reader) >= 2) {
      // File has header and at least one record row
      $reader->setHeaderOffset(0);
      $records = $reader->getRecords();
      $outputArr = [];
      foreach ($records as $offset => $record) {
        array_push($outputArr, $record);
      }

      $intermediate = Yaml::encode($outputArr);
    } else {
      // File is empty or has only headers
      $intermediate = '';
    }

    return new Kirby\Cms\Content(['csv' => $intermediate], $this);
  }

  protected function saveContent(array $data = null, bool $overwrite = false)
  {
    $clone = $this->clone();
    $clone->content()->update($data, $overwrite);
    $writer = Writer::createFromPath($this->root() . option('preya.kirby-csv-structure.csvFileName'), 'w+');
    $writer->setDelimiter(option('preya.kirby-csv-structure.delimiter'));
    $writer->setNewline(option('preya.kirby-csv-structure.lineEndings'));
    $intermediate = Yaml::decode($data['csv']);
    $headers = array_keys($intermediate[0]);
    $writer->insertOne($headers);
    $writer->insertAll($intermediate);
    return $clone;
  }
}
