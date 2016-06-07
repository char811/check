<?php

class City extends \Eloquent {

	// Don't forget to fill this array
	protected $fillable = ['engname','rusname'];


    public static $validate = array(
        'city'=>'required',

        'engname' => 'required',
    );

    public static $validate2 = array(
        'city'=>'required',
    );

    public static $rulesNewManager = array(

        'city'=>'required',

        'engname' => 'required:unique',

    );

    public static $messages = array(
        'city.required' => 'Please choose your city',
        'engname.required' => 'Укажите имя на англ.',
    );

    public function users()
    {
        return $this->belongsTo('User', 'city');
    }
}