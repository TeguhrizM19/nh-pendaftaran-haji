<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupKeberangkatan extends Controller
{
  public function index()
  {
    return view('keberangkatan.group-kebarangkatan');
  }
}
