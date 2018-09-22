<?php

namespace App\Http\Controllers;

use App\User;
use App\Salary;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    protected $_all_users;
    protected $_users;
    protected $_userIDs;
    protected $_subject_of_type;

    public function __construct()
    {
        $this->_users = User::whereIn('position', User::$staff_codes)
            ->whereNull('deleted_at')
            ->get();

        $this->_all_users = User::whereIn('position', User::$staff_codes)
            ->get();

        $this->_userIDs = array_column($this->_users->toArray(), 'uid');

        $subject_of_type = $code_to_type = Salary::$subject_code_to_type;

        foreach ($code_to_type as $type => $subject) {
            foreach ($subject as $code => $text) {
                $subject_of_type[$type][$code] = __('translate.amendment-subject/' . $text);
            }
        }

        $this->_subject_of_type = $subject_of_type;
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

        $salary = Salary::withTrashed();

        if ($whereq) {
            $date_range = [];
            foreach ($whereq as $key => $value) {
                if (in_array($key, ['from_date', 'to_date'])) {
                    $date_range[] = $value;
                } else if (is_array($value)) {
                    $salary->whereIn($key, $value);
                } else {
                    $salary->where($key, $value);
                }
            }
            if ($date_range) {
                $salary->whereBetween('cdate', $date_range);
            }
        }

        $adjustments = $salary->get();

        return view('salaries.index', [
            'adjustments' => $adjustments,
            'users' => $this->_all_users,
            'subjects' => $this->_subject_of_type,
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

        return view('salaries.create', [
            'users' => $this->_users,
            'subject_of_type' => $this->_subject_of_type,
            'faker' => [
                // 'uid' => $faker->randomElement(array_column($this->_users->toArray(), 'uid')),
                // 'type' => $faker->randomElement(['c', 'd']),
                // 'subject' => $faker->randomElement([10, 20, 30, 50, 60, 70]),
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
        $this->validate($request, [
            'uid' => 'required|in:' . implode(',', $this->_userIDs),
            'type' => 'required|in:c,d',
            'subject' => 'required|in:' . implode(',', Salary::$subject_type_to_code[$request->type] ?? []),
            'amount' => 'required|numeric|min:1',
            'remark' => 'required',
            'cdate' => 'required|date_format:Y-m-d',
        ]);

        $salary = Salary::create([
            'uid' => $request->uid,
            'type' => $request->type,
            'subject' => $request->subject,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'cdate' => $request->cdate,
        ]);

        $user = User::where('uid', '=', $salary->uid)->firstOrFail();

        session()->flash('added_adjustment', 'You successfully added a new adjustment. Username: ' . $user->username . ', Amount: RM ' . $request->amount);

        return redirect(route('salaries.create'));
        // return redirect(route('salaries.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        return view('salaries.edit', [
            'adjustment' => $salary,
            'users' => $this->_users,
            'subject_of_type' => $this->_subject_of_type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        $this->validate($request, [
            'uid' => 'required|in:' . implode(',', $this->_userIDs),
            'type' => 'required|in:c,d',
            'subject' => 'required|in:' . implode(',', Salary::$subject_type_to_code[$request->type] ?? []),
            'amount' => 'required|numeric|min:1',
            'remark' => 'required',
            'cdate' => 'required|date_format:Y-m-d',
        ]);

        $salary->uid = $request->uid;
        $salary->type = $request->type;
        $salary->subject = $request->subject;
        $salary->amount = $request->amount;
        $salary->remark = $request->remark;
        $salary->cdate = $request->cdate;
        $salary->save();

        $user = User::where('uid', '=', $salary->uid)->firstOrFail();

        session()->flash('updated_adjustment', 'You successfully updated a adjustment. ID: ' . $salary->id . ', Username: ' . $user->username . ', Amount: RM ' . $salary->amount);

        return redirect(route('salaries.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        $salary->delete();

        $user = User::where('uid', '=', $salary->uid)->firstOrFail();

        session()->flash('deleted_adjustment', 'You successfully deleted a adjustment. ID: ' . $salary->id . ', Username: ' . $user->username . ', Amount: RM ' . $salary->amount);

        return redirect(route('salaries.index'));
    }

    public function restore($id)
    {
        $salary = Salary::onlyTrashed()->find($id);
        $salary->restore();

        $user = User::where('uid', '=', $salary->uid)->firstOrFail();

        session()->flash('restored_adjustment', 'You successfully restored a adjustment. ID: ' . $salary->id . ', Username: ' . $user->username . ', Amount: RM ' . $salary->amount);

        return redirect(route('salaries.index'));
    }

    public function payslipForm()
    {
        $results = DB::table('sales')
            ->select(DB::raw("
                DISTINCT uid,
                DATE_FORMAT(cdate, '%Y-%m-01') AS month
                "))
            ->whereNull('deleted_at')
            ->orderBy('uid', 'asc')
            ->orderBy('month', 'desc')
            ->get()
            ->toArray();

        $individual_months = [];

        foreach ($results as $key => $record) {
            $individual_months[$record->uid][] = $record->month;
        }

        return view('payslips.index', [
            'users' => $this->_users,
            'individual_months' => $individual_months,
        ]);
    }

    public function payslipPrint(Request $request)
    {
        $data = json_decode($request->summary);

        return view('payslips.print', [
            'subject_types' => json_decode($request->subject_types, true),
            'user' => json_decode($request->user),
            'adjustments' => json_decode($request->adjustments, true),
            'epf_employer' => json_decode($request->epf_employer),
            'epf_employee' => json_decode($request->epf_employee),
            'total_addition' => json_decode($request->total_addition),
            'total_deduction' => json_decode($request->total_deduction),
            'gross_pay' => json_decode($request->gross_pay),
            'net_total' => json_decode($request->net_total),
            'comm' => json_decode($request->comm),
            'sale_summary' => json_decode($request->sale_summary, true),
            'date' => json_decode($request->date)
        ]);
    }

    public function payslip(Request $request)
    {
        $this->validate($request, [
            'uid' => 'required|in:' . implode(',', $this->_userIDs),
            'month' => 'required|date_format:Y-m-d',
        ]);

        $user = User::where('uid', $request->uid)->firstOrFail();

        $sale_results = DB::table('sales')
            ->select(DB::raw("
                cdate, 
                SUM(CASE WHEN service != '[]' AND product != '[]' THEN amount - pamount
                    WHEN service != '[]' THEN amount ELSE 0 END) AS total_service,
                SUM(CASE WHEN service != '[]' AND product != '[]' THEN pamount
                    WHEN product != '[]' THEN amount ELSE 0 END) AS total_product
            "))
            ->whereBetween('cdate', [date("Y-m-d", strtotime($request->month)), date('Y-m-t', strtotime($request->month))])
            ->where('uid', $request->uid)
            ->whereNull('deleted_at')
            ->groupBy('cdate')
            ->get()
            ->toArray();

        $ot_results = DB::table('salaries')
            ->select('cdate', DB::raw("SUM(amount) AS amount"))
            ->whereBetween('cdate', [date("Y-m-d", strtotime($request->month)), date('Y-m-t', strtotime($request->month))])
            ->where([
                ['uid', '=', $request->uid],
                ['subject', '=', Salary::$all_subject_type_to_code['ot']],
            ])
            ->whereNull('deleted_at')
            ->groupBy('cdate')
            ->get()
            ->toArray();

        $daily_ot = [];
        foreach ($ot_results as $result) {
            $daily_ot[$result->cdate] = $result->amount;
        }

        $results = DB::table('salaries')
            ->select(DB::raw("
                subject,
                SUM(amount) AS amount
                "))
            ->whereNull('deleted_at')
            ->where('uid', $request->uid)
            ->where(DB::raw("DATE_FORMAT(cdate, '%Y-%m-01')"), $request->month)
            ->groupBy('subject')
            ->get()
            ->toArray();

        $adjustments = [];

        foreach ($results as $key => $record) {
            $adjustments[$record->subject] = $record->amount;
        }

        $comm_results = DB::table('sales')
            ->select(DB::raw("
                SUM(CASE WHEN service != '[]' AND product != '[]' THEN (amount - pamount) * comm / 100
                    WHEN service != '[]' THEN amount * comm / 100 ELSE 0 END) AS service_comm,
                SUM(CASE WHEN service != '[]' AND product != '[]' THEN pamount * comm / 100
                    WHEN product != '[]' THEN amount * comm / 100 ELSE 0 END) AS product_comm
                "))
            ->whereNull('deleted_at')
            ->where('uid', $request->uid)
            ->where(DB::raw("DATE_FORMAT(cdate, '%Y-%m-01')"), $request->month)
            ->get();

        $comm = $comm_results[0];

        $credit_codes = array_keys(Salary::$subject_code_to_type['c']);
        $debit_codes = array_keys(Salary::$subject_code_to_type['d']);

        $total_deduction = $total_addition = 0;

        foreach ($adjustments as $code => $amount) {
            if (in_array($code, $credit_codes)) {
                $total_addition += $amount;
            } elseif (in_array($code, $debit_codes)) {
                $total_deduction += $amount;
            }
        }

        if ($request->has('epf_socso')) {
            $epf_employer = $user->salary * (Salary::$epf_percent['employer'] / 100);
            $epf_employee = $user->salary * (Salary::$epf_percent['employee'] / 100);

            $socso_employer = Salary::$socso['employer'];
            $socso_employee = Salary::$socso['employee'];
        } else {
            $epf_employer = $epf_employee = $socso_employer = $socso_employee = 0;
        }

        $total_addition += $comm->service_comm + $comm->product_comm;
        $total_deduction += $epf_employee + $socso_employee;

        $gross_pay = $user->salary + $total_addition;
        $net_total = $gross_pay - $total_deduction;

        $all_dates = [];
        $start_date = $request->month;
        $end_date = date('Y-m-t', strtotime($request->month));

        while ($start_date <= $end_date) {
            $all_dates[] = $start_date;
            $start_date = date('Y-m-d', strtotime($start_date . '+1 day'));
        }

        $formatted_sale_results = [];

        foreach ($sale_results as $sale) {
            $formatted_sale_results[$sale->cdate]['total_service'] = $sale->total_service;
            $formatted_sale_results[$sale->cdate]['total_product'] = $sale->total_product;
        }

        $sale_summary = [];
        $sale_dates = array_keys($formatted_sale_results);

        foreach ($all_dates as $date) {
            $sale_summary[$date] = [];
            if (in_array($date, $sale_dates)) {
                $sale_summary[$date]['total_service'] = $formatted_sale_results[$date]['total_service'];
                $sale_summary[$date]['total_product'] = $formatted_sale_results[$date]['total_product'];
            } else {
                $sale_summary[$date]['total_service'] = 0;
                $sale_summary[$date]['total_product'] = 0;
            }
            $sale_summary[$date]['total_ot'] = $daily_ot[$date] ?? 0;
        }

        return view('payslips.show', [
            'subject_types' => Salary::$subject_type_to_code,
            'user' => $user,
            'adjustments' => $adjustments,
            'epf_employer' => $epf_employer,
            'epf_employee' => $epf_employee,
            'socso_employer' => $socso_employer,
            'socso_employee' => $socso_employee,
            'total_addition' => $total_addition,
            'total_deduction' => $total_deduction,
            'gross_pay' => $gross_pay,
            'net_total' => $net_total,
            'comm' => $comm,
            'sale_summary' => $sale_summary,
            'date' => date('F d, Y', strtotime($request->month))
        ]);
    }

    public function search(Request $request)
    {
        $request->flash();
        $whereq = [];
        $search_fields = ['uid', 'subject', 'from_date', 'to_date'];

        foreach ($search_fields as $field) {
            if (isset($_POST[$field]) && !empty($_POST[$field])) {
                $whereq[$field] = $_POST[$field];
            }
        }

        return $this->index($whereq);
    }
}
