<?php

namespace App\Http\Controllers;

use App\User;
use App\Salary;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class SalaryController extends Controller
{
    protected $_users;
    protected $_userIDs;
    protected $_subject_of_type;

    public function __construct()
    {
        $this->_users = User::whereIn('position', User::$staff_codes)
            ->whereNull('deleted_at')
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
    public function index()
    {
        $salary = Salary::withTrashed()->get();

        return view('salaries.index', [
            'adjustments' => $salary
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
                'uid' => $faker->randomElement(array_column($this->_users->toArray(), 'uid')),
                'type' => $faker->randomElement(['c', 'd']),
                'subject' => $faker->randomElement([10, 20, 30, 50, 60, 70]),
                'amount' => $faker->numberBetween(50, 200),
                'remark' => $faker->sentence(),
                'cdate' => $faker->date(),
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

        session()->flash('added_adjustment', 'You successfully added a new adjustment. Name: ' . $request->uid . ', Amount: ' . $request->amount);

        return redirect(route('salaries.index'));
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

        session()->flash('updated_adjustment', 'You successfully updated a adjustment, ID: ' . $salary->id . '.');

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

        session()->flash('deleted_adjustment', 'You successfully deleted a adjustment, Name: ' . $salary->id . '.');

        return redirect(route('salaries.index'));
    }

    public function restore($id)
    {
        $salary = Salary::onlyTrashed()->find($id);
        $salary->restore();

        session()->flash('restored_adjustment', 'You successfully restored a adjustment, Name: ' . $salary->id . '.');

        return redirect(route('salaries.index'));
    }
}
