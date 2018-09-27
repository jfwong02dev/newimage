<?php

namespace App\Http\Controllers;

use App\Sale;
use App\User;
use App\Service;
use App\Product;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SaleController extends Controller
{
    protected $_users;
    protected $_all_services;
    protected $_available_services;
    protected $_all_products;
    protected $_available_products;
    protected $_userIDs;

    public function __construct()
    {
        $this->_users = User::whereIn('position', User::$staff_codes)
            ->whereNull('deleted_at')
            ->get();

        $this->_userIDs = array_column($this->_users->toArray(), 'uid');

        $this->_available_services = Service::all();
        $this->_available_products = Product::all();

        $this->_all_services = Service::withTrashed()->get();
        $this->_all_products = Product::withTrashed()->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($whereq = [])
    {
        $search = strpos($_SERVER['REQUEST_URI'], 'search') ? true : false;
        if (!$search) {
            session()->forget('_old_input');
        }

        $start_of_last_month = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $end_of_this_month = Carbon::now()->endOfMonth()->toDateString();

        $sales = Sale::whereBetween('cdate', [$start_of_last_month, $end_of_this_month]);

        if ($whereq) {
            $date_range = [];
            foreach ($whereq as $key => $value) {
                if (in_array($key, ['from_date', 'to_date'])) {
                    $date_range[] = $value;
                } else if (in_array($key, ['service', 'product'])) {
                    foreach ($value as $code) {
                        $sales->where($key, 'like', '%' . $code . '%');
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

        return view('sales.index', [
            'users' => $this->_users,
            'sales' => $sales,
            'services' => $service_code_to_name,
            'products' => $product_code_to_name,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faker = Faker::create();
        $comm_types = Sale::$comm_types;

        $service_code_to_name = [];
        foreach ($this->_all_services as $service) {
            $service_code_to_name[$service->code] = $service->name;
        }

        $product_code_to_name = [];
        foreach ($this->_all_products as $product) {
            $product_code_to_name[$product->code] = $product->name;
        }

        return view('sales.create', [
            'users' => $this->_users,
            'services' => $this->_available_services,
            'products' => $this->_available_products,
            'service_code_to_name' => $service_code_to_name,
            'product_code_to_name' => $product_code_to_name,
            'comm_types' => $comm_types,
            'faker' => [
                // 'uid' => $faker->randomElement(array_column($this->_users->toArray(), 'uid')),
                // 'service' => $faker->randomElements(array_column($this->_available_services->toArray(), 'code'), 3),
                // 'product' => $faker->randomElements(array_column($this->_available_products->toArray(), 'code'), 2),
                // 'comm' => $faker->randomElement($comm_types),
                // 'amount' => $faker->numberBetween(50, 200),
                // 'remark' => $faker->sentence(),
                // 'cdate' => $faker->date(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('bulkService') && $request->bulkService !== null) {
            $request->merge(['service' => explode(',', $request->bulkService)]);
        }
        if ($request->has('bulkProduct') && $request->bulkProduct !== null) {
            $request->merge(['product' => explode(',', $request->bulkProduct)]);
        }

        $extra_rules = [];
        if ($request->service && $request->product) {
            $extra_rules['pamount'] = 'required|numeric|min:1';
            if ($request->pamount) {
                $extra_rules['amount'] = 'required|numeric|gt:pamount';
            }
        }

        $this->validate($request, array_merge([
            'uid' => 'required|in:' . implode(',', $this->_userIDs),
            'service' => 'required_without:product|array',
            'service.*' => 'required|string|in:' . implode(',', array_column($this->_available_services->toArray(), 'code')),
            'product' => 'required_without:service|array',
            'product.*' => 'required|string|in:' . implode(',', array_column($this->_available_products->toArray(), 'code')),
            'comm' => 'required|in:' . implode(',', Sale::$comm_types),
            'amount' => 'required|numeric|min:1',
            'cdate' => 'required|date_format:Y-m-d',
        ], $extra_rules));

        $sales = Sale::create([
            'uid' => $request->uid,
            'service' => json_encode($request->service ?? []),
            'product' => json_encode($request->product ?? []),
            'comm' => $request->comm,
            'pamount' => $request->pamount ?? 0,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'cdate' => $request->cdate,
        ]);

        $user = User::where('uid', '=', $sales->uid)->firstOrFail();

        session()->flash('added_sale', 'You successfully added a new sale. Username: ' . $user->username . ', Amount: ' . env('CUR') . $sales->amount);

        return redirect(route('sales.create'));
        // return redirect(route('sales.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $service_code_to_name = [];
        foreach ($this->_all_services as $service) {
            $service_code_to_name[$service->code] = $service->name;
        }

        $product_code_to_name = [];
        foreach ($this->_all_products as $product) {
            $product_code_to_name[$product->code] = $product->name;
        }

        return view('sales.edit', [
            'sale' => $sale,
            'users' => $this->_users,
            'services' => $this->_available_services,
            'products' => $this->_available_products,
            'service_code_to_name' => $service_code_to_name,
            'product_code_to_name' => $product_code_to_name,
            'comm_types' => Sale::$comm_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        if ($request->has('bulkService') && $request->bulkService !== null) {
            $request->merge(['service' => explode(',', $request->bulkService)]);
        }
        if ($request->has('bulkProduct') && $request->bulkProduct !== null) {
            $request->merge(['product' => explode(',', $request->bulkProduct)]);
        }

        $extra_rules = [];
        if ($request->service && $request->product) {
            $extra_rules['pamount'] = 'required|numeric|min:1';
            if ($request->pamount) {
                $extra_rules['amount'] = 'required|numeric|gt:pamount';
            }
        }
        try {
            $this->validate($request, array_merge([
                'uid' => 'required|in:' . implode(',', $this->_userIDs),
                'service' => 'required_without:product|array',
                'service.*' => 'required|string|in:' . implode(',', array_column($this->_available_services->toArray(), 'code')),
                'product' => 'required_without:service|array',
                'product>*' => 'required|string|in:' . implode(',', array_column($this->_available_products->toArray(), 'code')),
                'comm' => 'required|in:' . implode(',', Sale::$comm_types),
                'amount' => 'required|numeric|min:1',
                'cdate' => 'required|date_format:Y-m-d',
            ], $extra_rules));
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        $sale->uid = $request->uid;
        $sale->service = json_encode($request->service ?? []);
        $sale->product = json_encode($request->product ?? []);
        $sale->pamount = $request->pamount ?? 0;
        $sale->comm = $request->comm;
        $sale->amount = $request->amount;
        $sale->remark = $request->remark;
        $sale->cdate = $request->cdate;
        $sale->save();

        session()->flash('updated_sale', 'You successfully updated a sale, ID: ' . $sale->id . '.');

        return redirect(route('sales.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        session()->flash('deleted_sale', 'You successfully deleted a sale, ID: ' . $sale->id . '.');

        return redirect(route('sales.index'));
    }

    public function restore($id)
    {
        $sale = Sale::onlyTrashed()->find($id);
        $sale->restore();

        session()->flash('restored_sale', 'You successfully restored a sale, ID: ' . $sale->id . '.');

        return redirect(route('sales.index'));
    }

    public function search(Request $request)
    {
        $request->flash();
        $uri = $request->path();
        $path = explode('/', $uri);

        $whereq = [];
        $search_fields = ['uid', 'service', 'product', 'comm', 'from_date', 'to_date'];

        foreach ($search_fields as $field) {
            if (isset($_POST[$field]) && !empty($_POST[$field])) {
                $whereq[$field] = $_POST[$field];
            }
        }

        switch ($path[0]) {
            case 'sales':
                return $this->index($whereq);
                break;

            default:
                dd('wrong path');
                break;
        }
    }
}
