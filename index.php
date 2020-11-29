<?php
@include_once __DIR__ . '/vendor/autoload.php';
@include_once __DIR__ . '/page-models/CsvStructurePage.php';

Kirby::plugin('preya/kirby-csv-structure', [
  'pageModels' => [
    'csv-data' => 'CsvStructurePage'
  ],
  'options' => [
    'delimiter' => ';',
    'lineEndings' => "\r\n",
    'csvFileName' => '/structure.csv',
  ]
]);