<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class UsiaChart
{
  public function build($usiaCounts)
  {
    return (new LarapexChart)
      ->barChart() // Ubah dari donutChart ke barChart
      ->setTitle('Rentang Usia')
      ->setDataset([
        [
          'name' => 'Jumlah',
          'data' => array_values($usiaCounts)
        ]
      ])
      ->setLabels(array_keys($usiaCounts));
  }
}
