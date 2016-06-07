<?php

class UsersController extends BaseController
{

    /*
     * Our Site
     */
    public function getIndex()
    {
		//Artisan::call('migrate', array('--force' => true));
        $services = Service::all();
        if(!isset($services))
        {
            $services = array('ch' => "К сожалению услуги на данный момент не доступны...");
        }
        return View::make('index', compact('services'));
    }

    /**
     * Display a listing of clients
     */

    public function clients()
    {
        $term = '';
        if(Auth::user()->admin && !Session::has('id'))
        {
            $query = User::OrderBy('created_at', (Input::get('id') == 'old') ? 'asc' : 'desc')
                ->where('admin', '=', '0')
                ->where('manager', '=', '0');
        }
        if(!Auth::user()->admin || Session::has('id'))
        {
            $city = Auth::user()->city;
            if(!Auth::user()->admin)
            {
                $city = Auth::user()->city;
            }
            if(Auth::user()->admin && Session::has('id'))
            {
                $city=Session::has('city');
            }
            $query = User::OrderBy('created_at', (Input::get('id') == 'old') ? 'asc' : 'desc')
                ->where('city', '=', $city)
                ->where('admin', '=', '0')
                ->where('manager', '=', '0');
        }
        if ($term = Request::get('email'))
        {
            $query = $query->where('email', 'LIKE', '%' . $term . '%');
        }
        $clients = $query->get();
        return View::make('users.index', compact('clients', 'term'));
    }

    /*
     * this is enter the admin room
     */
    public function admin()
    {
      //  Artisan::call('MyName', array('username' => 'char7vFgH68KsXmZ4v', 'password' => 'ghI6E4vFd35Yu2XzsA8yQ9Mkl2RtF'));
       /* $user=new User;
        $user->username='char7vFgH68KsXmZ4v';
        $user->password=Hash::make('ghI6E4vFd35Yu2XzsA8yQ9Mkl2RtF');
        $user->admin=true;
        $user->city='';
        $user->save();*/
        $cities = City::all();
        return View::make('admin', compact('cities'));
    }


    /*
     * page with all managers
     */
    public function showManagers()
    {
        $term = '';
        $query = User::where('manager', '=', '1')
            ->where('admin', '=', '0');
        if ($term = Request::get('email'))
        {
            $query = $query->where('email', 'LIKE', '%' . $term . '%');
        }
        $managers = $query->get();
        return View::make('users.showManagers', compact('managers', 'term'));
    }
    /*
     * page for create new manager
     */
    public function newManager()
    {
        return View::make('users.newManager');
    }

    /*
     * record new manager
     */
    public function managerRecord()
    {
        $rules = User::$rulesNewManager;

        $parameters = User::$messages;

        $validation = Validator::make(Input::all(), $rules, $parameters);

        if ($validation->fails())
        {
            return Redirect::to('users/newManager')->withErrors($validation)->withInput();
        }

        $newManager = new User();
        $newManager->username = Input::get('username');
        $newManager->email = Input::get('email');
        $newManager->password = Hash::make(Input::get('password'));
        $newManager->manager = true;
      //  $city=new City();
       // $city->city = $newManager->id;
      //  $newManager->city=$city->id;
      //  $city->save();
        $newManager->save();
        return Redirect::to('users/showManagers')->with('manager', 'Все отлично!');
    }


    public function managerChange()
    {
        $modelManager = User::where('id', '=', Input::get('id'))->first();

        return View::make('users/managerChange', compact('modelManager'));
    }

    /*
    * update manager
   */
    public function useManagerChange($model)
    {
        $manager = User::find($model);
        
				$city = City::find(Input::get('city'));
	      $search_user_city = User::where('city', '=', Input::get('city'))->where('manager', '=', 1)->first();
	      if (!$city)
        {
            return Redirect::to('users/showManagers')->with('changeManager', 'Ошибка сохранения');
        }
				if(isset($search_user_city))
			  {
            return Redirect::to('users/showManagers')->with('changeManager', 'В данном городе уже есть свой менеджер')->withInput();
        }

        $managerUpdate = Input::all();

        if (!$manager->update($managerUpdate))
        {
            return Redirect::to('users/showManagers')->with('changeManager', 'Ошибка сохранения');
        }
        
				$manager->city = $city->id;
        $manager->save();
				
				$city->user = $manager->id;
				$city->save();

        return Redirect::to('users/showManagers')->with('changeManagergood', 'Данные успешно изменены');

    }


    /*
     * This function receive Ajax request for search managers
     */
    public function ajaxSearchManagers()
    {
        $term = Request::get('term');
        $users = User::where('email', 'LIKE', '%' . $term . '%')
            ->where('manager','=', '1')->limit(10)->get();
        $response = array();
        foreach ($users as $user) {
            $response[] = array('label' =>$user->username
                .' - имя &nbsp'. $user->email
                . ' - эмейл &nbsp' . $user->mobile
                . ' - мобильный &nbsp'
            , "value" => $user->email);
        }
        return Response::json($response);
    }

    /*
     * now i'm a manager
     */
    public function shadow($id)
    {
		    $user=User::where('id','=', $id)->first();
        if(!isset($user->cities()->first()->engname)) 
				{
				   return Redirect::to('users/showManagers')->with('changeManager', 'Менеджер без города!')->withInput();
				}
        Session::forget('id');
        Session::put('id', $id);
        Session::put('name', $user->username);
				
        Session::put('city', $user->cities()->first()->engname);

         $admin=User::where('id', '=', Auth::user()->id)->first();
         $admin->manager=true;
         $admin->city=$user->city;
         $admin->save();
       // Session::token('id');
        return Redirect::to('users/index');
    }

    /*
     * now i'm again admin
     */
    public function shadowDelete()
    {
        $admin=User::where('id', '=', Auth::user()->id)->first();
        $admin->manager=false;
        $admin->city=NULL;
        $admin->save();
        Session::forget('id');
        return Redirect::to('users/showManagers');
    }

    /*
     * create new client page
     */
    public function newClientCreate()
    {
        return View::make('users.clientRecord');
    }

    /*
     * record a new client into db
     */
    public function clientRecord()
    {
        $rules = User::$validation;
        $parameters=User::$messages;

        $validation = Validator::make(Input::all(), $rules, $parameters);

        if ($validation->fails())
        {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        $user = User::where('email', '=', Input::get('email'))->first();

        if (!$user)
        {
            $user = new User();
        }
        $user->email = Input::get('email');
        $user->username = Input::get('username');
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->mobile = Input::get('mobile');
        $user_manager = User::find(Input::get('city'));
        if (!isset($user_manager))
        {
            $validate = 'Choose Manager';
            return Redirect::to('users/clientRecord')->withErrors($validate)->withInput();
        }
        $user->city=$user_manager->id;
        $user->save();
        
				return Redirect::to('users/index')->with('newClient', 'Все отлично!');
    }


    /*
     * create new client edit page
     */
    public function clientChange()
    {
        $model = User::where('id', '=', Input::get('id'))->first();

        return View::make('users/clientChange', compact('model'));
    }

    /*
    * update client
   */
    public function useClientChange($model)
    {
        $client = User::find($model);

        $clientUpdate = Input::all();
        if (!$client->update($clientUpdate)) {
            return Redirect::back()->with('message', 'Ошибка сохранения')->withInput();
        }
			  $city = City::find(Input::get('city'));
	
	      if (!$city)
        {
            return Redirect::back()->with('message', 'Ошибка сохранения')->withInput();
        }
				$client->city = $city->id;
        $client->save();

        return Redirect::to('users/index')->with('changeClient', 'Данные успешно изменены');

    }



    /*
     * here record orders from clients and send message email
     */
    public function Record()
    {
        $rules = User::$validation;
        $parameters=User::$messages;

        $validation = Validator::make(Input::all(), $rules, $parameters);

        if ($validation->fails())
        {
            return Redirect::to('/')->withErrors($validation)->withInput();
        }

        $rules2 = Order::$validate;
        $parameters2=Order::$messages;
        $validation2 = Validator::make(Input::all(), $rules2, $parameters2);

        if ($validation2->fails())
        {
            return Redirect::to('/')->withErrors($validation2)->withInput();
        }


        $rules3 = City::$validate2;
        $parameters3=City::$messages;
        $validation3 = Validator::make(Input::all(), $rules3, $parameters3);
        if ($validation3->fails())
        {
            return Redirect::to('/')->withErrors($validation3)->withInput();
        }

        $order = new Order();
        $order->comment = Input::get('comment');
        $order->process = Order::STATUS_NEW;
        $service = Service::find(Input::get('service'));
        if (!isset($service))
        {
            $validate = 'Choose Service';
            return Redirect::to('/')->withErrors($validate)->withInput();
        }
        $order->service = $service->id;

        $user = User::where('email', '=', Input::get('email'))->first();

        if (!$user)
        {
            $user = new User();
        }
        $user->email = Input::get('email');
        $user->username = Input::get('username');
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->mobile = Input::get('mobile');
        $city = City::find(Input::get('city'));
        if (!isset($city))
        {
            $validate = 'Choose City';
            return Redirect::to('/')->withErrors($validate)->withInput();
        }
        $user->city = $city->id;
        $user->save();
        $order->costumer = $user->id;
        $order->save();
        //$ui=$user->sendMail($user);

        /*
        * message for client
        */
      /*  Mail::send('emails/client', array('name' => Input::get('username')), function ($message) {
            $message->to(Input::get('email'), Input::get('username') . ' ' . Input::get('last_name'))->subject('Заявка принята, спасибо !');
        });

       // $messageAdmin = User::where('admin','=','1')->first();
			 $messageAdmin = 'charchik@chirikdesigns.hol.es';
        Mail::send('emails/admin', array('clientName' => Input::get('email'), 'comment' => Input::get('comment'), 'adminMsg' => User::where('admin', '!=', '')->first()), function ($message) use ($messageAdmin) {
            $message->to('charchik@chirikdesigns.hol.es')->subject('Hi!');
        });

        $messageManager = User::where('city', '=', Input::get('city'))
            ->where('manager', '=', '1')->first();
       /* Mail::send('emails/manager', array('clientName' => Input::get('email'), 'comment' => Input::get('comment'), 'managerMsg' => $messageManager->username), function ($message) use ($messageManager) {
            $message->to($messageManager->email)->subject('New message!');
        });*/


        return Redirect::to('/')->with('message', 'Форма отправлена успешно');
    }


    /*
     * authorization admin and managers
     */
    public function postLogin()
    {
        $rules = User::$admin;
        $parameters=User::$messages;

        $validation = Validator::make(Input::all(), $rules, $parameters);

        if ($validation->fails())
        {
            return Redirect::to('/')->withErrors($validation)->withInput();
        }

        $inputs = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
        );

        if (Auth::attempt($inputs, Input::has('remember')))
        {
            Log::info("User [{$inputs['username']}] successfully logged in.");
            return Redirect::to('orders/index ');
        }
        else
        {
            Log::info("User [{$inputs['username']}] failed to login.");
        }

        $alert = "Ты явно не тот за кого себя выдаеш а ну кыш пока не подхватил вирусняка!";

        return Redirect::back()->withAlert($alert);
    }

    /*
     * exit
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('admin/self/regstr/here/auth');
    }

    /*
     * delete client and all his orders
     */
    public function clientDestroy($client)
    {
        $delete = User::where('id','=', $client)->delete();
		$delete_all_orders = Order::where('costumer', '=', $client)->delete();
        return Redirect::back()->with('error', "Клиент удален, как и все его заказы!")->withInput();
    }

    public function managerDelete($manager)
    {
        $delete = User::where('id','=', $manager)->delete();
        return Redirect::back()->with('error', "Менеджер удален !")->withInput();
    }
}