<?php
use models\Message;

class Application{
  public static function main(){
    self::registe();
  
  }
  public static function registe(){
    spl_autoload_register("Application::loadClass");
  }
  public static function loadClass($class){
    $class=str_replace('\\', '/', $class);
    $class="./".$class.".php";
    require_once $class;    
  }
}
Application::main();


$client = new Mosquitto\Client();
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');
$client->connect("localhost", 1883, 5);
$client->onLog('logger');
$client->subscribe('#', 1);

$client->loopForever();

function connect($r, $message) {
	echo "I got code {$r} and message {$message}\n";
}
function subscribe() {
	echo "Subscribed to a topic\n";
}
function unsubscribe() {
	echo "Unsubscribed from a topic\n";
}
function message($message) {
	$mesM = new Message();

	$data['message']=$Message->payload;
	$data['create_time']=time();
	$mesM->insert('mg_msg',$data);
	printf("Got a message on topic %s with payload:\n%s\n", $message->topic, $message->payload);
}
function disconnect() {
	echo "Disconnected cleanly\n";
}
function logger() {
	var_dump(func_get_args());
}