<?php


/**
 * Class Order
 */
class Order extends \Eloquent {

    const STATUS_NEW = 'Новый';
    const STATUS_IN_PROCESS = 'В обработке';
    const STATUS_PROCESSED = 'Обработан';
    const STATUS_REJECTED = 'Отклонен';

    protected $table = 'orders';

	// Add your validation rules here
    public static $validate = array(
		'service'=>'required',

        'comment' => 'required',
    );

    public static $rulesNewManager = array(

        'service'=>'required|unique:orders',

        'comment' => 'required',

    );

    public static $messages = array(
        'service.required' => 'Please choose new service',
        'comment.required' => 'Field with message required coz how should we know your wishes?',
    );

	// Don't forget to fill this array
	protected $fillable = [ 'created_at', 'service', 'comment', 'process','price','costumer'];

    /**
     *
     * Функция возвращает Email пользователя
     *
     * @return mixed
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public static $statmessage=array(
        'Новый' =>'Новый',
        'В обработке'=> 'В обработке',
        'Обработан'=> 'Обработан',
        'Отклонен'=>'Отклонен',
    );

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getcostumer()
    {
        return $this->belongsTo('User', 'costumer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getservice()
    {
        return $this->belongsTo('Service', 'service');
    }

}