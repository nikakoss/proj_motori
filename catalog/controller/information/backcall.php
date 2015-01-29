<?php 
class ControllerInformationBackcall extends Controller {
	private $error = array(); 
	    
  	public function index() {
$komu ="iurise@yahoo.com";
$tema="обратный звонок";

mail($komu,$tema,  "Имя отправителя ".$_POST['fio']."\n телефон :".$_POST['bphone']);

?>
	

	<h2>Сообщение отправлено, наш менеджер свяжется с Вами</h2>

	
	<?php 
	//print_r($_POST);
	}	
}
?>
