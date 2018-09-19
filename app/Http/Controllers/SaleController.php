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
    public function index()
    {
        $sales = Sale::whereDate('created_at', Carbon::today())->get();

        $service_code_to_name = [];
        foreach ($this->_all_services as $service) {
            $service_code_to_name[$service->code] = $service->name;
        }

        $product_code_to_name = [];
        foreach ($this->_all_products as $product) {
            $product_code_to_name[$product->code] = $product->name;
        }

        return view('sales.index', [
            'sales' => $sales,
            'services' => $service_code_to_name,
            'products' => $product_code_to_name
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

        return view('sales.create', [
            'users' => $this->_users,
            'services' => $this->_available_services,
            'products' => $this->_available_products,
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
        $extra_rules = [];
        if ($request->service && $request->product) {
            $extra_rules['pamount'] = 'required|numeric|min:1';
            $extra_rules['amount'] = 'required|numeric|gt:pamount';
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
        return view('sales.edit', [
            'sale' => $sale,
            'users' => $this->_users,
            'services' => $this->_available_services,
            'products' => $this->_available_products,
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
        $extra_rules = [];
        if ($request->service && $request->product) {
            $extra_rules['pamount'] = 'required|numeric|min:1';
            $extra_rules['amount'] = 'required|numeric|gt:pamount';
        }

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
}
