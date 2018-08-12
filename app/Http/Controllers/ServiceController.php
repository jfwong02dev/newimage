<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::withTrashed()->get();

        return view('services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'serviceName' => 'required|unique:services,name|min:3',
        ]);

        $service = Service::create([
            'name' => $request->serviceName,
        ]);

        $service->code = 'SV' . $service->id;
        $service->save();

        session()->flash('added_service', 'You successfully added a new service. Name: ' . $request->serviceName);

        return redirect(route('services.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $this->validate($request, [
            'editServiceName' => 'required|min:3|unique:services,name,' . $service->id,
        ]);

        $service->name = $request->editServiceName;
        $service->save();

        session()->flash('updated_service', 'You successfully updated a service, ID: ' . $service->id . '.');

        return redirect(route('services.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        session()->flash('deleted_service', 'You successfully deleted a service, Name: ' . $service->name . '.');

        return redirect(route('services.index'));
    }

    public function restore($id)
    {
        $service = Service::onlyTrashed()->find($id);
        $service->restore();

        session()->flash('restored_service', 'You successfully restored a service, Name: ' . $service->name . '.');

        return redirect(route('services.index'));
    }
}
