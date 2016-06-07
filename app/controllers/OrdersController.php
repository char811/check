<?php

class OrdersController extends \BaseController
{

    /**
     * Display a listing of orders
     *
     */
    public function orders()
    {
        $query = Order::OrderBy('created_at', (Input::get('id') == 'old') ? 'asc' : 'desc');
        $term = '';
/*        $allothers = Order::where('process', '=', Order::STATUS_NEW)
            ->orWhere('process', '=', Order::STATUS_PROCESSED)
            ->orWhere('process', '=', Order::STATUS_REJECTED)->get();
        $dateoneday = Carbon::now();
        $datesevenday = Carbon::now()->subDays(7);
        $ones = Order::where('process', '=', Order::STATUS_IN_PROCESS)
            ->where('created_at', '>=', $datesevenday)
            ->where('created_at', '<=', $dateoneday)->get();
        $dateoneweek = Carbon::now()->subDays(7);
        $datetwoweek = Carbon::now()->subDays(14);
        $oneweeks = Order::where('process', '=', Order::STATUS_IN_PROCESS)
            ->where('created_at', '>=', $datetwoweek)
            ->where('created_at', '<=', $dateoneweek)->get();
        $twoweek = Carbon::now()->subDays(14);
        $ninemonth = Carbon::now()->subWeeks(300);
        $twoweeks = Order::where('process', '=', Order::STATUS_IN_PROCESS)
            ->where('created_at', '>=', $ninemonth)
            ->where('created_at', '<=', $twoweek)->get();
*/

        $ok=Order::select( DB::raw('CASE
                         WHEN DATEDIFF(NOW(), created_at)>=5 AND DATEDIFF(NOW(), created_at)<8 THEN IF(process = "Новый" OR process ="В обработке", "oneweek", "new")
                         WHEN DATEDIFF(NOW(), created_at)>=8 AND DATEDIFF(NOW(), created_at)<21 THEN IF(process = "Новый" OR process ="В обработке", "twoweek", "new")
                         ELSE "new"
                         END AS old, id'))->get();


        if(Auth::user()->admin && !Session::has('id')){
            if ($term = Request::get('email'))
            {
                $query = $query->whereHas('getcostumer', function ($q) use ($term) {
                    return $q->where('email', 'LIKE', '%' . $term . '%');
                });
            }
            $ords = $query->get();
            return View::make('orders.index', compact('ords', 'term', 'ok'));
        }

        if(!Auth::user()->admin || Session::has('id')) {
            if(!Auth::user()->admin)
            {
                $city = Auth::user()->city;
            }
            if(Auth::user()->admin && Session::has('id'))
            {
                $city=Session::has('city');
            }
            $query = Order::OrderBy('created_at', (Input::get('id') == 'old') ? 'asc' : 'desc')
                ->whereHas('getcostumer', function ($k) use ($city) {
                return $k->where('city', '=', $city);
            });
            if ($term = Request::get('email'))
            {
                $query = $query->whereHas('getcostumer', function ($q) use ($term) {
                    return $q->where('email', 'LIKE', '%' . $term . '%');
                });
            }
            $ords = $query->get();
            return View::make('orders.index', compact('ords', 'term', 'ok'));
        }
    }

    /*
     * This function uses Ajax request return on statistic page all service pyramid
     */

    public function pyramid()
    {
        $service = Input::get('service');

        if (Auth::user()->admin && !Session::has('id'))
        {
            $new = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_NEW)->count();
            $process = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_IN_PROCESS)->count();
            $processed = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_PROCESSED)->count();
            $rejected = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_REJECTED)->count();
            $mark = Order::where('service', '=', $service)->count();
        }
        if(!Auth::user()->admin || Session::has('id'))
        {
            /**
             * This code worked only for ROLE~manager
             */
            if(!Auth::user()->admin)
            {
                $city = Auth::user()->city;
            }
            if(Auth::user()->admin && Session::has('id'))
            {
                $city=Session::has('city');
            }

            $new = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_NEW)
                ->whereHas('getcostumer', function ($y) use ($city) {
                    return $y->where('city', '=', $city);
                })->count();

            $process = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_IN_PROCESS)
                ->whereHas('getcostumer', function ($y) use ($city) {
                    return $y->where('city', '=', $city);
                })->count();
            $processed = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_PROCESSED)
                ->whereHas('getcostumer', function ($y) use ($city) {
                    return $y->where('city', '=', $city);
                })->count();
            $rejected = Order::where('service', '=', $service)
                ->where('process', '=', Order::STATUS_REJECTED)
                ->whereHas('getcostumer', function ($y) use ($city) {
                    return $y->where('city', '=', $city);
                })->count();
            $mark = Order::where('service', '=', $service)
                ->whereHas('getcostumer', function ($y) use ($city) {
                    return $y->where('city', '=', $city);
                })->count();
        }
        /*
         * below code for count percent orders
         */
        $newCount = $new;
        if ($newCount != 0) $newPercent = floor(($newCount / $mark) * 100); else $newPercent = 0;
        $processCount = $process;
        if ($processCount != 0) $processPercent = floor(($processCount / $mark) * 100); else $processPercent = 0;
        $processedCount = $processed;
        if ($processedCount != 0) $processedPercent = floor(($processedCount / $mark) * 100); else $processedPercent = 0;
        $rejectedCount = $rejected;
        if ($rejectedCount != 0) $rejectedPercent = floor(($rejectedCount / $mark) * 100); else $rejectedPercent = 0;
        /*
         * create array for return back json data
         */
        $orders = [['name' => Order::STATUS_NEW.':  ' . $newPercent . '%  ', 'data' => $new,'service' => $service],
                   ['name' => Order::STATUS_IN_PROCESS.':  ' . $processPercent . '%  ', 'data' => $process],
                   ['name' => Order::STATUS_PROCESSED.':  ' . $processedPercent . '%  ', 'data' => $processed],
                   ['name' => Order::STATUS_REJECTED.':  ' . $rejectedPercent . '%  ', 'data' => $rejected]];

        return Response::json($orders);

    }

    /*
     * This function for create statistic page
     */

    public function statistics()
    {
        $services = Service::all();
		
				foreach($services as $serv)
				{
				   $ord = Order::where('service', '=', $serv->id)->first();
					 if(isset($ord))
					 {
					    $orders[$ord->service] = $ord->service;
					 }
				}
				
        if (Auth::user()->admin && !Session::has('id'))
        {
            $towns = City::all()->count();
            $countClients = User::where('manager', '=', '0')->count();
            $countManagers = User::where('manager', '=', '1')->count();
            $countOrders = Order::all()->count();
        }
        if (!Auth::user()->admin && Session::has('id'))
        {
            $city = Auth::user()->city;

            $countClients = User::where('manager', '=', '0')
                ->where('city', '=', $city)->count();
            $countManagers = User::where('manager', '=', '1')
                ->where('city', '=', $city)->count();
            $countOrders = Order::whereHas('getcostumer', function ($y) use ($city) {
                    return $y->where('city', '=', $city);
            })->count();
        }
        if (Auth::user()->admin && Session::has('id'))
        {
            $user=User::where('id','=', Session::has('id'))->first();
            $city=Session::has('city');


        $countClients = User::where('manager', '=', '0')
            ->where('city', '=', $city)->count();
        $countManagers = User::where('manager', '=', '1')
            ->where('city', '=', $city)->count();
        $countOrders = Order::whereHas('getcostumer', function ($y) use ($city) {
            return $y->where('city', '=', $city);
        })->count();
        }
        return View::make('orders.statistics',
            compact('towns', 'countClients', 'countManagers', 'countOrders', 'services', 'orders'));
    }

    /*
     * This function receive Ajax request for search clients or orders
     */
    public function ajaxSearchClientsOrOrders()
    {
        $term = Request::get('term');
        $users = User::where('email', 'LIKE', '%' . $term . '%')->limit(10)->get();
        $response = array();
        foreach ($users as $user)
        {
            $response[] = array('label' =>$user->username
                                       .' - имя &nbsp'. $user->email
                                       . ' - эмейл &nbsp' . $user->mobile
                                       . ' - мобильный &nbsp'
                               , "value" => $user->email);
        }
        return Response::json($response);
    }


    /*
    * create a new order page
    */
    public function newOrderCreate()
    {
        return View::make('orders.orderRecord');
    }

    /*
     * record a new order into db
     */
    public function orderRecord()
    {
        $rules = Order::$validate;
        $parameters=Order::$messages;
        $validation = Validator::make(Input::all(), $rules, $parameters);

        if ($validation->fails())
        {
            return Redirect::to('orders/orderRecord')->withErrors($validation)->withInput();
        }
        if (Input::get('process')=='default')
        {
            $validate = 'Choose Process';
            return Redirect::to('orders/orderRecord')->withErrors($validate)->withInput();
        }

        $order = new Order();
        $order->comment = Input::get('comment');
        $order->process = Input::get('process');
        $order->price = Input::get('price');
        $service = Service::find(Input::get('service'));
        if (!isset($service))
        {
            $validate = 'Choose Service';
            return Redirect::to('orders/orderRecord')->withErrors($validate)->withInput();
        }
        $order->service = $service->id;

        $user = User::where('email', '=', Input::get('email'))->first();

        if (!$user) $user = new User();
        $user->email = Input::get('email');
        $user->mobile = Input::get('mobile');
        $user->save();
        $order->costumer = $user->id;
        $order->save();
        return Redirect::to('orders/index')->with('newOrder', 'Все отлично!');
    }

    /*
    * create new order edit page
   */
    public function orderChange()
    {
        $modelOrder = Order::where('id', '=', Input::get('id'))->first();

        return View::make('orders/orderChange', compact('modelOrder'));
    }


    /*
     * update order
     */
    public function useOrderChange($modelOrder)
    {
        $order = Order::find($modelOrder);
        $update = Input::all();
        $thisOrder = Order::where('id', '=', $modelOrder)->first();
        $process = Input::get('process');

        if (($thisOrder->process) != $process)
        {
            $userMail = User::where('id', '=', $thisOrder->costumer)->first();
            if ($process == Order::STATUS_IN_PROCESS)
            {
                Mail::send('emails/test', array('data' => Input::get('price')), function ($message) use ($userMail) {
                    $message->to($userMail->email)->subject('Заказ!');
                });
            };
            if ($process == Order::STATUS_REJECTED)
            {
                Mail::send('emails/test', array('data' => Input::get('id')), function ($message) use ($userMail) {
                    $message->to($userMail->email)->subject('Заказ!');
                });
            }
        }
        if (!$order->update($update))
        {
            return Redirect::back()->with('message', 'Ошибка сохранения')->withInput();
        }
        $order->save();

        return Redirect::to('orders/index')->with('changeOrder', 'Данные успешно изменены');
    }




    public function create()
    {
        return View::make('orders.create');
    }


    public function store()
    {
        $validator = Validator::make($data = Input::all(), Order::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Order::create($data);

        return Redirect::route('orders.index');
    }

    /**
     * Display the specified order.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return View::make('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $order = Order::find($id);

        return View::make('orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $order = Order::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Order::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $order->update($data);

        return Redirect::route('orders.index');
    }

    /**
     *delete order
     */
    public function orderDestroy()
    {
        $delete=Order::where('id','=', Input::get('id'))->delete();
        return Redirect::to('orders/index');
    }

}
