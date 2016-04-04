<?php
namespace Kit\MakerBundle\Util;

use Kit\MakerBundle\Util\pdf\kit_bienvenidaa;
/**
 * GenerarPDF.
 */
class MandarEmail
{

	protected $mailer;

	protected $mail_address;

	protected $mail_addreses;
	
	public function __construct($mailer, $mail_address, $mail_addreses)
	{

		$this->mailer = $mailer;
		$this->mail_address = $mail_address;
		$this->mail_addreses = $mail_addreses;
	}

	public function mandarEmail(array $data){

		$message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject($data['_usersubject'])
                ->setFrom($this->mail_address)
                ->addTo($data['_useremail'])                
                ->setCc($this->mail_addreses)                
                ->setBody($data['_userbody'])
                ->attach(\Swift_Attachment::fromPath('/var/www/html/KitMaker/src/Kit/MakerBundle/Util/pdf/Bienvenido.pdf'));

           $this->mailer->send($message);
                
}
}