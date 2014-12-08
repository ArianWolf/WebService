
<?php
class ServiceController extends Controller {



	public function actionIndex() {
		$this->result(array("status" => "ON", "name" => "REST API MovieTheater"));
	}

/**
 Acceso Aplicaciones (Seguridad) 
 */
	private function headers() {
		header('Access-Control-Allow-Origin:*');
    	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    	header('Access-Control-Allow-Headers: Content-Type, apikey');
	}

/**
 ACTIONS PARA OBTENER LAS CIUDADES Y LOS COMPLEJOS
*/
 	private function result($result) {
		echo json_encode($result);// lo regresa a quien al que llama controlador
	}
	
	public function actionReserva(){
			$this->headers();

			$tarjeta = $_GET['tarjeta'];
			$password = $_GET['password'];
			$precio = $_GET['precio']; 

			$Respuesta=Tarjetas::model()->buscarTarjeta($tarjeta,$password,$precio);
			$this->result($Respuesta);

		}
	public function actionTiempoLimite()
	{
		$this->headers();
		$devolucion= $_GET['devolucion'];
		$tarjeta=$_GET['tarjeta'];

		$Respuesta=Tarjetas::model()->depositarDevolucion($tarjeta,$devolucion);
		$this->result($Respuesta);

	}	
	


}