<?php

class mensajeria {
	var $DBHost = 'localhost';
	var $DBName = 'milibreria';
	var $DBUser = 'root';
	var $DBPass = '';
	var $tblName = 'mensajes';	
	
	
	 /*
	 *	@desc Class constructor
	 *	@param String $tblName
	 *	@return mensajeria	retorna el objeto
	 *	@return Int	1	Si la base de datos no se puede seleccionar despues de conectar
	 *	@return Int 2	Si la conexion a MySQL falla
	 *	@return Int 3	Si la base de datos no se puede seleccionar cuando se conecta a la base de datos desde fuera de la clase
	 *	@return Int 4	Si la variable de conexion no es correcta
	 */
	function mensajeria($connect = false,$selectDB = false,$con = '')
	{		
		if($connect)
		{
			$con = @mysql_connect($this->DBHost,$this->DBUser,$this->DBPass);
			if($con)
				if(!@mysql_select_db($this->DBName,$con))
					return 1;
			else 
				return 2;
		}elseif ($selectDB)
		{
			if( strlen($con) > 0 )
				if(!@mysql_select_db($this->DBName,$con))
					return 3;
			else 
				return 4;
		}
	}



	/**
	* @desc Envia mensaje a $receiver desde $sender
	* @return Int 0		Mensaje enviado correctamente
	* @return Int 1		Sin titulo
	* @return Int 2		Sin contenido
	* @return Int 3		Emisor no valido
	* @return Int 4		Receptor no valido
	* @return Int 6		Error al grabar en la base de datos
	*
	* @param String $title
	* @param String $body
	* @param Int $sender
	* @param Int $receiver
	*/
	function SendMessege($title ,$body ,$sender ,$receiver)
	{
		if( strlen($title) == 0 )
			return 1;
		if( strlen($body) == 0 )
			return 2;
		if( strlen($sender) == 0 )
			return 3;
		if( strlen($receiver) == 0 )
			return 4;
		$fecha=date('Y-m-d H:i:s', time());
		$result = mysql_query("INSERT INTO ".$this->tblName." (titulo,contenido,emisor,receptor) VALUES ('$title','$body',$sender,$receiver)");
		if($result)
			return 0;
		else 	
			return 6;
	}


	/**
	* @desc Retorna el mensaje y todas sus especificaciones
	* @return int 1		Cuando msgId es igual a 0
	* @return int 2		Cuando no hay mensaje en la base de datos con ese msgId
	* @return array 	Retorna el array con todos los campos
	* @param int $msgId
	*/
	function GetMessege($msgId)
	{
		$messege = array();
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT * FROM ".$this->tblName." WHERE id=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		
		$messege['id'] = $row->id;
		$messege['receptor'] = $row->receptor;
		$messege['emisor'] = $row->emisor;
		$messege['titulo'] = $row->titulo;
		$messege['contenido'] = $row->contenido;
		$messege['leido'] = $row->leido;
		$messege['fecha_envio'] = $row->fecha_envio;
		$messege['fecha_leido'] = $row->fecha_leido;
		$this->MarkAsRead($row->id);
		return $messege;
	}


	/**
	* @desc Elimina un mensaje
	* @return Int 0		Eliminación correcta
	* @return Int 1		Cuando msgId es igual a 0
	* @return Int 2		Error al eliminar de la base d edatos
	* @param Int $msgId
	*/
	function DeleteMessege($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("DELETE FROM ".$this->tblName." WHERE id=$msgId");
		if($result)
			return 0;
		else 
			return 2;
	}


	/**
	* @desc Marca el mensaje como leido
	* @return Int 0		Marcado como leido correctamente
	* @return Int 1		Cuando msgId es igual a 0
	* @return Int 2		Error al actualizar la base de datos
	* @param Int $msgId
	*/
	function MarkAsRead($msgId)
	{	
		$fecha=date('Y-m-d H:i:s', time());
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("UPDATE ".$this->tblName." SET leido='si', fecha_leido='$fecha' WHERE id=$msgId");
		if($result)
			return 0;
		else 
			return 2;
	}


	/**
	* @desc Marca el mensaje como no leido
	* @return Int 0		Marcado como no leido correctamente
	* @return Int 1		Cuando msgId es igual a 0
	* @return Int 2		Error al actualizar la base de datos
	* @param Int $msgId
	*/
	function MarkAsUnRead($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("UPDATE ".$this->tblName." SET leido='no' WHERE id=$msgId");
		if($result)
			return 0;
		else 
			return 2;
	}


	/**
	* @desc Retorna todos los mensajes ordenados por fecha_envio recibidos por el usuario $receiver
	* @return Int 1			Error al recoger informacion de la base de datos
	* @return Int 2			No hay mensajes con estas opciones
	* @return Array			Retorna el array con todos los mensajes
	* 
	* @param Int $receiver
	*
	*/
	function GetAllMesseges($receiver)
	{
		
		
		$result = @mysql_query("SELECT * FROM ".$this->tblName." WHERE receptor=$receiver ORDER BY fecha_envio ASC");
		
		if( !$result )
		return 1;
		//echo $num = mysql_num_rows($result);
		$num = mysql_num_rows($result);
		$messege = '';
		for($i = 0 ; $i < $num ; $i++ )
		{
			$row = mysql_fetch_object($result);
			
			$messege[$i]['id'] = $row->id;
			$messege[$i]['receptor'] = $row->receptor;
			$messege[$i]['emisor'] = $row->emisor;
			$messege[$i]['titulo'] = $row->titulo;
			$messege[$i]['contenido'] = $row->contenido;
			$messege[$i]['leido'] = $row->leido;
			$messege[$i]['fecha_envio'] = $row->fecha_envio;
			$messege[$i]['fecha_leido'] = $row->fecha_leido;
			
		}
		if( !is_array($messege) )
			return 2;
		return $messege;
				
	}
	
	
	function GetAllMessegesSent($receiver)
	{
		
		
		$result = @mysql_query("SELECT * FROM ".$this->tblName." WHERE emisor=$receiver ORDER BY fecha_envio ASC");
		
		if( !$result )
		return 1;
		//echo $num = mysql_num_rows($result);
		$num = mysql_num_rows($result);
		$messege = '';
		for($i = 0 ; $i < $num ; $i++ )
		{
			$row = mysql_fetch_object($result);
			
			$messege[$i]['id'] = $row->id;
			$messege[$i]['receptor'] = $row->receptor;
			$messege[$i]['emisor'] = $row->emisor;
			$messege[$i]['titulo'] = $row->titulo;
			$messege[$i]['contenido'] = $row->contenido;
			$messege[$i]['leido'] = $row->leido;
			$messege[$i]['fecha_envio'] = $row->fecha_envio;
			$messege[$i]['fecha_leido'] = $row->fecha_leido;
			
		}
		if( !is_array($messege) )
			return 2;
		return $messege;
				
	}
	



}
?>