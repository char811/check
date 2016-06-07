<?php

class ServicesController extends \BaseController {

	/**
	 * Display a listing of services
	 *
	 * @return Response
	 */


	/*public function index()
	{
		$services = Service::all();
        //$uss=User::all();

		return View::make('services.index', compact('services'));
        //return View::make('services.index', ['services' => $services]);
	}*/

	/**
	 * Show the form for creating a new service
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('services.index');
	}


	/**
	 * Store a newly created service in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
 	       $rules = Service::$valid;
				 $my = Service::$my;

        $valid = Validator::make(Input::all(), $rules, $my);
		
		if ($valid->fails())
		{
			return Redirect::to('services/index')->withErrors($valid)->withInput();
		}

		
        $ser= new Service();
        $ser->fill(Input::all());
        $ser->save();
        return Redirect::to('services/index')->with('message', 'Данные успешно введены');
	}

	/**
	 * Display the specified service.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$service = Service::findOrFail($id);

		return View::make('services.show', compact('service'));
	}

	/**
	 * Show the form for editing the specified service.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$service = Service::find($id);

		return View::make('services.edit', compact('service'));
	}

	/**
	 * Update the specified service in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$service = Service::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Service::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$service->update($data);

		return Redirect::route('services.index');
	}

	/**
	 * Remove the specified service from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Service::destroy($id);

		return Redirect::route('services.index');
	}

}
