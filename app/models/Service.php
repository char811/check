<?php

class Service extends \Eloquent {

	// Add your validation rules here
  public static $valid = array(
		'name'=>'required|unique:services',
	);
	  public static $my = array(
		'name'=>'shift_dash',
	);
 public static $messages = array(
     'name.shift_dash' => 'Only numbers, letters and spaces or & ',
	);

	// Don't forget to fill this array
	protected $fillable = ['name'];

	protected $table = 'services';


}