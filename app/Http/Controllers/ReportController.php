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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->_all_users = User::withTrashed()->where('uid', '!=', 10001)->get();
        $this->_available_users = User::where('uid', '!=', 10001)->get();

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
        $search = strpos($_SERVER['REQUEST_URI'], 'search') ? true : false;
        if (!$search) {
            session()->forget('_old_input');
        }

        $sales = Sale::where('deleted_at', null);

        if ($whereq) {
            $date_range = [];
            foreach ($whereq as $key => $value) {
                if (in_array($key, ['from_date', 'to_date'])) {
                    $date_range[] = $value;
                } else if (is_array($value)) {
                    $sales->whereIn($key, $value);
                } else {
                    $sales->where($key, $value);
                }
            }
            if ($date_range) {
                if (count($date_range) === 1) {
                    $date_range[] = Carbon::now()->toDateString();
                }
                $sales->whereBetween('cdate', $date_range);
            }
        }

        $sales = $sales->get();

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
            'search' => $search,
        ]);
    }

    public function saleCompare(Request $request)
    {
        $monthly_sales = DB::table('sales')
            ->select(DB::raw("
            DATE_FORMAT(cdate, '%Y-%m') AS month,
            SUM(amount) AS total_sales
            "))
            ->whereNull('deleted_at')
            ->groupBy(DB::raw("DATE_FORMAT(cdate, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(cdate, '%Y-%m')"))
            ->get();

        $all_months = [];
        $sales_by_month = [];
        foreach ($monthly_sales as $key => $value) {
            $month = date("F Y", strtotime($value->month));
            array_push($all_months, $month);
            $sales_by_month[$month] = $value->total_sales;
        }

        return view('reports.sales-compare', [
            'all_months' => $all_months,
            'sales_by_month' => $sales_by_month,
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

    public function allSale($whereq = [])
    {
        $search = strpos($_SERVER['REQUEST_URI'], 'search') ? true : false;
        if (!$search) {
            session()->forget('_old_input');
        }

        $sales = Sale::where('deleted_at', null);

        if ($whereq) {
            $date_range = [];
            foreach ($whereq as $key => $value) {
                if (in_array($key, ['from_date', 'to_date'])) {
                    $date_range[] = $value;
                } else if (in_array($key, ['service', 'product'])) {
                    foreach ($value as $code) {
                        if ($code) {
                            $sales->where($key, 'LIKE', '%"' . $code . '"%');
                        }
                    }
                } else if (is_array($value)) {
                    $sales->whereIn($key, $value);
                } else {
                    $sales->where($key, $value);
                }
            }

            if ($date_range) {
                if (count($date_range) === 1) {
                    $date_range[] = Carbon::now()->toDateString();
                }
                $sales->whereBetween('cdate', $date_range);
            }
        }

        $sales = $sales->get();

        $service_code_to_name = [];
        foreach ($this->_all_services as $service) {
            $service_code_to_name[$service->code] = $service->name;
        }

        $product_code_to_name = [];
        foreach ($this->_all_products as $product) {
            $product_code_to_name[$product->code] = $product->name;
        }

        return view('reports.all-sales', [
            'users' => $this->_all_users,
            'sales' => $sales,
            'services' => $service_code_to_name,
            'products' => $product_code_to_name,
            'search' => $search
        ]);
    }

    public function search(Request $request)
    {
        $request->flash();
        $uri = $request->path();
        $path = explode('/', $uri);

        $whereq = [];
        $search_fields = ['uid', 'service', 'product', 'comm', 'from_date', 'to_date', 'first_month', 'second_month'];

        foreach ($search_fields as $field) {
            if (isset($_POST[$field]) && !empty($_POST[$field])) {
                $whereq[$field] = $_POST[$field];
            }
        }

        switch ($path[0]) {
            case 'sales-details-report':
                return $this->saleDetail($whereq);
                break;

            case 'all-sales-report':
                return $this->allSale($whereq);
                break;

            case 'sales-compare-report':
                return $this->saleCompare($whereq);
                break;

            default:
                dd('wrong path');
                break;
        }
    }
}
