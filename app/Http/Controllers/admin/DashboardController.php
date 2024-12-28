<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\e_store\Order;

class DashboardController extends Controller
{
   public function index(){
          // Fetching metrics
          $newOrders = Order::count();
          $totalUsers = User::count();
          $bounceRate = 53; // Placeholder or calculate if available
          $uniqueVisitors = 65; 
          return view('admin.dashboard', compact('newOrders', 'totalUsers', 'bounceRate', 'uniqueVisitors'));   }
}


