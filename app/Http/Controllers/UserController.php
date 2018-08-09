<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class UserController extends Controller
{
    protected $_position;

    public function __construct()
    {
        $this->middleware('auth');
        $this->_position = User::$position_code_to_text;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withTrashed()->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faker = Faker::create();
        return view('users.create', [
            'position' => $this->_position,
            'faker' => [
                'username' => $faker->firstName,
                'fullname' => $faker->name,
                'gender' => $faker->randomElement(['m', 'f']),
                'ic' => $faker->e164PhoneNumber,
                'email' => $faker->email,
                'mobile' => $faker->phoneNumber,
                'address' => $faker->address,
                'position' => $faker->randomElement(array_keys($this->_position)),
                'salary' => $faker->numberBetween(1000, 3000),
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
            'username' => 'required|unique:users',
            'fullname' => 'required',
            'gender' => 'required|in:m,f',
            'ic' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'mobile' => 'required',
            'address' => 'required',
            'position' => 'required|in:' . implode(',', User::$position_to_code),
            'salary' => 'required|numeric',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'ic' => $request->ic,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'position' => $request->position,
            'salary' => $request->salary,
        ]);

        $user->uid = 10000 + $user->id;
        $user->save();

        session()->flash('added_user', 'You successfully added a new user. Name: ' . $request->username);

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'editServiceName' => 'required|min:3|unique:services,name,' . $user->id,
        ]);

        $user->name = $request->editServiceName;
        $user->save();

        session()->flash('updated_user', 'You successfully updated a user, ID: ' . $user->id . '.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('deleted_user', 'You successfully deleted a user, Name: ' . $user->username . '.');

        return redirect(route('users.index'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();

        session()->flash('restored_user', 'You successfully restored a user, Name: ' . $user->username . '.');

        return redirect(route('users.index'));
    }
}
