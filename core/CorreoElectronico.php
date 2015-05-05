<?php
//incluimos la librería
require_once ('../librerias/PHPMailer/PHPMailerAutoload.php');

class CorreoElectronico {
	
	//Atributos privados
	private $phpMailer = null;
	private $port = 465;
	private $host = "smtp.gmail.com";
	private $mail_user = 'txemapuente71@gmail.com';
	private $mail_pass = 'delhorror';
	private $appName = 'MobileBlog App';
	private $type_smtp = 'ssl';
	
	//Constructor
	function CorreoElectronico($debug=false){
		// crear un objeto de la libreria PHPMailer
		$this->phpMailer = new PHPMailer ();
		// indico a la clase que use SMTP
		$this->phpMailer->IsSMTP ();
		// permite modo debug para ver mensajes de las cosas que van ocurriendo
		if($debug){
			$this->phpMailer->SMTPDebug = 2;
		}
		// Debo de hacer autenticación SMTP
		$this->phpMailer->SMTPAuth = true;
		$this->phpMailer->SMTPSecure = $this->type_smtp;
		
		// indico el servidor de Gmail para SMTP
		$this->phpMailer->Host = $this->host;
		// indico el puerto que usa Gmail
		$this->phpMailer->Port = $this->port;
		
		// indico un usuario / clave de un usuario de gmail
		$this->phpMailer->Username = $this->mail_user;
		$this->phpMailer->Password = $this->mail_pass;
		
		// indicar desde donde enviamos
		$this->phpMailer->SetFrom ( $this->mail_user, $this->appName );
		// indicar remitente
		$this->phpMailer->AddReplyTo ( $this->mail_user, $this->appName );
	}
		
	//Metodos
	public static function mandarMail($address, $nombre) {
		// crear un objeto de la libreria PHPMailer
		$mail = new PHPMailer ();
		// indico a la clase que use SMTP
		$mail->IsSMTP ();
		// permite modo debug para ver mensajes de las cosas que van ocurriendo
		// $this->phpMailer->SMTPDebug = 2;
		// Debo de hacer autenticación SMTP
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		
		// indico el servidor de Gmail para SMTP
		$mail->Host = "smtp.gmail.com";
		// indico el puerto que usa Gmail
		$mail->Port = 465;//$this::$port;
		
		// indico un usuario / clave de un usuario de gmail
		$mail->Username = "gaizkamontero20@gmail.com";
		$mail->Password = "gmontero20";
		
		// indicar desde donde enviamos
		$mail->SetFrom ( 'gaizkamontero20@gmail.com', 'MobileBlog App' );
		// indicar remitente
		$mail->AddReplyTo ( "gaizkamontero20@gmail.com", "MobileBlog App" );
		// Asunto
		$mail->Subject = "Ongi Etorri a MobileBlog";
		// Cuerpo del mensaje
		// $this->phpMailer->MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");
		$plantilla = file_get_contents ( "../plantillas/nuevo-usuario.html" );
		$contenido = str_replace ( "{usuario}", $nombre, $plantilla );
		$mail->MsgHTML ( $contenido );
		// $this->phpMailer->MsgHTML(file_get_contents('../plantillas/nuevo-usuario.html'));
		// indico destinatario
		// $address = "gaizkamontero20@gmail.com";
		$mail->AddAddress ( $address, $nombre );
		if (! $mail->Send ()) {
			echo "Error al enviar: " . $mail->ErrorInfo;
		} else {
			echo "Mensaje enviado!";
		}
	}
	
	function enviar(){
		return $this->phpMailer->send();
	}
	
	//Getters y setters
	function setAsunto($asunto){
		$this->phpMailer->Subject=$asunto;
	}
	
	function setDestinatario($destinatario){
		$this->phpMailer->addAddress($destinatario);
	}
	
	function setCuerpo($cuerpo){
		$this->phpMailer->msgHTML($cuerpo);
	}
	
}