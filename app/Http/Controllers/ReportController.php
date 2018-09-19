<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Product;
use App\Salary;
use App\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
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

    protected $_search_fields = [
        'from_date', 'to_date',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->_all_users = User::withTrashed()->get();
        $this->_available_users = User::all();

        $this->_all_services = Service::withTrashed()->get();
        $this->_available_services = Service::all();

        $this->_all_products = Product::withTrashed()->get();
        $this->_available_products = Product::all();

        $this->_all_adjustments = Salary::withTrashed()->get();
        $this->_available_adjustments = Salary::all();

        $this->_all_sales = Sale::withTrashed()->get();
        $this->_available_sales = Sale::all();
    }

    public function saleDetail($whereq = [])
    {
        foreach ($this->_search_fields as $field) {
            if (in_array($field, array('from_date', 'to_date'))) {
                $type = 'date';
            } else {
                $type = 'text';
            }

            $value = !empty($_POST[$field]) ? $_POST[$field] : '';


            $this->_fields[$field]['name'] = $field;
            $this->_fields[$field]['type'] = $type;
            $this->_fields[$field]['value'] = $value;
        }

        $sales = DB::table('sales')
            ->whereBetween('cdate', $whereq ? $whereq : [date(Carbon::minValue()), date(Carbon::minValue())])
            ->get();

        $serviceSummary = [];
        $productSummary = [];

        foreach ($sales as $sale) {
            $serviceArr = json_decode($sale->service);
            foreach ($serviceArr as $scode) {
                if (!in_array($scode, array_keys($serviceSummary))) {
                    $serviceSummary[$scode] = 1;
                } else {
                    $serviceSummary[$scode]++;
                }
            }
            $productArr = json_decode($sale->product);
            foreach ($productArr as $pcode) {
                if (!in_array($pcode, array_keys($productSummary))) {
                    $productSummary[$pcode] = 1;
                } else {
                    $productSummary[$pcode]++;
                }
            }
        }

        return view('reports.sales-details', [
            'sales' => $sales,
            'all_services' => $this->_all_services,
            'all_products' => $this->_all_products,
            'services_summary' => $serviceSummary,
            'products_summary' => $productSummary,
            'search' => strpos($_SERVER['REQUEST_URI'], 'search') ? true : false,
            'search_fields' => $this->_fields,
        ]);
    }

    public function monthlySale()
    {
        $monthly_sales = DB::table('sales')
            ->select(DB::raw("
                DATE_FORMAT(cdate, '%Y-%m') AS month,
                SUM(amount) AS total_sales,
                SUM(CASE WHEN service != '[]' THEN 1 ELSE 0 END) AS total_services,
                SUM(CASE WHEN product != '[]' THEN 1 ELSE 0 END) AS total_products
                "))
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("DATE_FORMAT(cdate, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(cdate, '%Y-%m')"))
            ->get();

        return view('reports.monthly-sales', [
            'monthly_sales' => $monthly_sales
        ]);
    }

    public function yearlySale()
    {
        $yearly_sales = DB::table('sales')
            ->select(DB::raw("
                DATE_FORMAT(cdate, '%Y') AS year,
                SUM(amount) AS total_sales,
                SUM(CASE WHEN service != '[]' THEN 1 ELSE 0 END) AS total_services,
                SUM(CASE WHEN product != '[]' THEN 1 ELSE 0 END) AS total_products
                "))
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("DATE_FORMAT(cdate, '%Y')"))
            ->orderBy(DB::raw("DATE_FORMAT(cdate, '%Y')"))
            ->get();

        return view('reports.yearly-sales', [
            'yearly_sales' => $yearly_sales
        ]);
    }

    public function allSale()
    {
        $sales = Sale::all();

        $service_code_to_name = [];
        foreach ($this->_all_services as $service) {
            $service_code_to_name[$service->code] = $service->name;
        }

        $product_code_to_name = [];
        foreach ($this->_all_products as $product) {
            $product_code_to_name[$product->code] = $product->name;
        }

        return view('reports.all-sales', [
            'sales' => $sales,
            'services' => $service_code_to_name,
            'products' => $product_code_to_name
        ]);
    }

    public function search(Request $request)
    {
        $whereq = [];
        if ($_POST) {
            foreach ($this->_search_fields as $field) {
                if (isset($_POST[$field]) && !empty($_POST[$field]) && in_array($field, ['from_date', 'to_date'])) {
                    $whereq[] = date($_POST[$field]);
                }
            }
        }

        return $this->saleDetail($whereq);
    }
}
