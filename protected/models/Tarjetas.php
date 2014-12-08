<?php 

class Tarjetas extends CActiveRecord
{
	public $Tarjeta;
	public $Password;
	public $Credito;

	public function tableName()
	{
		return "tarjetas";
	}

	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	public function buscarTarjeta($tar,$pass,$prec)
	{
		
		//consulta y obtencion de datos
		$id=$tar;
		$Criteria = new CDbCriteria();
		$Criteria->condition = "tarjeta = :tarjeta";
		$Criteria->params = array(":tarjeta" => $id);	
		$Resultado = $this->findAll($Criteria);
		
		// verifica si encontró la tarjeta en la bd
		if($Resultado==null)
			return "la tarjeta no existe";

		//validar que no sean numeros negativos 
		if($prec<0)	
		 	return "no se permiten número negativos";
        

		// verifica que las contraseñas coincidan
		$passbd= $Resultado[0]->Password;
		if($passbd!=$pass)
			return "las contraseñas no coinciden";

		//verifica si el saldo es mayor al precio
		$cred= $Resultado[0]->Credito;
		if($prec>$cred)
			return "Credito insuficiente";
		// realiza el update
		$update = Yii::app()->db->createCommand()
    	->update('tarjetas', 
        array(
            'credito'=>new CDbExpression('credito-'.$prec),
        ),
        'tarjeta=:tarjeta',
        array(':tarjeta'=>$tar)
    	);
		
		return true;


	}

	public function depositarDevolucion($tar,$dev)
	{
		$update = Yii::app()->db->createCommand()
    	->update('tarjetas', 
        array(
            'credito'=>new CDbExpression('credito+'.$dev),
        ),
        'tarjeta=:tarjeta',
        array(':tarjeta'=>$tar)
    	);

    	return true;

	}






}