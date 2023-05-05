<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataExport implements FromArray, WithMapping, WithHeadings
{
  // public function collection()
  // {
  //   return session('collections');
    
  // }
  public function array(): array
  {
    return session('collections');
  }

  public function map($data): array
  {
    return [
      $data['Retailer'] ?? ' ',
      $data['City'] ?? ' ',
      $data['A_Brands'] ?? ' ',
      $data['C_Model'] ?? ' ',
      ($data['A_Brands'] ?? ' ') . ($data['C_Model'] ?? ' '),
      $data['F_Sales units'] ?? ' ',
      $data['G_Unit price'] ?? ' ',
      number_format(($data['F_Sales units'] ?? 0) * ($data['G_Unit price'] ?? 0))
    ];
  }

  public function headings(): array
  {
    return [
      'Retailer', 
      'City', 
      'Brand', 
      'Model', 
      'Brand + Model', 
      'Sales Unit', 
      'Unit Price', 
      'Sales Value'
    ];
  }
}