<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Product;
use App\Salary;
use App\Sale;

use Carbon\Carbon;

class HomeController extends Controller
{
    protected $_all_users;
    protected $_available_users;
    protected $_all_services;
    protected $_available_services;
    protected $_all_products;
    protected $_available_products;
    protected $_all_adjustments;
    protected $_available_adjustments;
    protected $_all_sales;
    protected $_available_sales;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->_all_users = User::withTrashed()->get();
        // $this->_available_users = User::all();

        // $this->_all_services = Service::withTrashed()->get();
        // $this->_available_services = Service::all();

        // $this->_all_products = Product::withTrashed()->get();
        // $this->_available_products = Product::all();

        // $this->_all_adjustments = Salary::withTrashed()->get();
        // $this->_available_adjustments = Salary::all();

        // $this->_all_sales = Sale::withTrashed()->get();
        // $this->_available_sales = Sale::all();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = new Sale();
        $sales_calendar = $sales->dailySale();
        $monthly_statistic = $sales->monthlyStatistic();
        $daily_sales = [];
        $daily_sales_by_month = [];
        $lowest_of_month = [];
        $highest_of_month = [];
        $daily_sales_by_month = [];
        $monthly_statistic_chart = [];

        foreach ($sales_calendar as $record) {
            $firstDayOfMonth = date('Y-m-01', strtotime($record->date));
            $daily_sales_by_month[$firstDayOfMonth][$record->date] = $record->total;
        }

        foreach ($daily_sales_by_month as $month) {
            $lowest_of_month = array_merge($lowest_of_month, array_keys($month, min($month)));
            $highest_of_month = array_merge($highest_of_month, array_keys($month, max($month)));
        }

        if (count($sales_calendar)) {
            foreach ($sales_calendar as $li => $record) {
                $daily_sales[$li]['title'] = "RM " . $record->total;
                $daily_sales[$li]['start'] = $record->date;
            }
        }

        if (count($monthly_statistic)) {
            foreach ($monthly_statistic as $record) {
                $monthly_statistic_chart['month'][] = Carbon::parse($record->month)->format('M');
                $monthly_statistic_chart['total_service'][] = $record->total_service;
                $monthly_statistic_chart['total_product'][] = $record->total_product;
            }
        }

        return view('home', [
            'daily_sales' => $daily_sales,
            'monthly_statistic_chart' => $monthly_statistic_chart,
            'lowest_of_month' => $lowest_of_month,
            'highest_of_month' => $highest_of_month,
        ]);
        // return view('home', [
        //     'no_of_all_users' => count($this->_all_users->toArray()),
        //     'no_of_available_users' => count($this->_available_users->toArray()),
        //     'no_of_all_services' => count($this->_all_services->toArray()),
        //     'no_of_available_services' => count($this->_available_services->toArray()),
        //     'no_of_all_products' => count($this->_all_products->toArray()),
        //     'no_of_available_products' => count($this->_available_products->toArray()),
        //     'no_of_all_adjustments' => count($this->_all_adjustments->toArray()),
        //     'no_of_available_adjustments' => count($this->_available_adjustments->toArray()),
        //     'no_of_all_sales' => count($this->_all_sales->toArray()),
        //     'no_of_available_sales' => count($this->_available_sales->toArray()),
        // ]);
    }
}
