<?php

class CitiesController extends \BaseController {

	/**
	 * Display a listing of cities
	 *
	 * @return Response
	 */
	public function index()
	{
		$cities = City::all();

		return View::make('cities.index', compact('cities'));
	}

	/**
	 * Show the form for creating a new city
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cities.index');
	}

	/**
	 * Store a newly created city in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), City::$validate, City::$rulesNewManager);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $ci= new City();
        $ci->engname=Input::get('engname');
        $ci->rusname=Input::get('rusname');
        $user = User::find(Input::get('city'));
        if (!isset($user))
        {
            $user = 'Choose Manager';
            return Redirect::to('cities/index')->withErrors($user)->withInput();
        }
        $ci->user = $user->id;
        $ci->save();
        $user->city=$ci->id;
        $user->save();
        return Redirect::to('cities/index')->with('message', 'Данные успешно введены');
	}

	/**
	 * Display the specified city.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$city = City::findOrFail($id);

		return View::make('cities.show', compact('city'));
	}

	/**
	 * Show the form for editing the specified city.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$city = City::find($id);

		return View::make('cities.edit', compact('city'));
	}

	/**
	 * Update the specified city in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$city = City::findOrFail($id);

		$validator = Validator::make($data = Input::all(), City::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$city->update($data);

		return Redirect::route('cities.index');
	}

	/**
	 * Remove the specified city from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		City::destroy($id);

		return Redirect::route('cities.index');
	}

}
