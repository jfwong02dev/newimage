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
        $users = User::withTrashed()
            ->where('uid', '!=', 10001)
            ->get();

        return view('users.index', [
            'users' => $users
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
        return view('users.create', [
            'faker' => [
                // 'username' => $faker->firstName,
                // 'fullname' => $faker->name,
                // 'gender' => $faker->randomElement(['m', 'f']),
                // 'ic' => $faker->e164PhoneNumber,
                // 'email' => $faker->email,
                // 'mobile' => $faker->phoneNumber,
                // 'address' => $faker->address,
                // 'position' => $faker->randomElement(array_keys($this->_position)),
                // 'salary' => $faker->numberBetween(1000, 3000),
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

        $user->uid = User::$staff_no + $user->id;
        $user->save();

        session()->flash('added_user', 'You successfully added a new user. Username: ' . $request->username);

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
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
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
            'username' => 'required|unique:users,username,' . $user->id,
            'fullname' => 'required',
            'gender' => 'required|in:m,f',
            'ic' => 'required|unique:users,ic,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required',
            'address' => 'required',
            'position' => 'required|in:' . implode(',', User::$position_to_code),
            'salary' => 'required|numeric',
        ]);

        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->gender = $request->gender;
        $user->ic = $request->ic;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->position = $request->position;
        $user->salary = $request->salary;
        $user->save();

        session()->flash('updated_user', 'You successfully updated a user, UID: ' . $user->uid . '.');

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

        session()->flash('deleted_user', 'You successfully deleted a user, Username: ' . $user->username . '.');

        return redirect(route('users.index'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();

        session()->flash('restored_user', 'You successfully restored a user, Username: ' . $user->username . '.');

        return redirect(route('users.index'));
    }
}
