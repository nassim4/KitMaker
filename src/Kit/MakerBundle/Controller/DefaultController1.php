<?php

namespace Kit\MakerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kit\MakerBundle\Entity\Enquiry;
use Kit\MakerBundle\Form\EnquiryType;
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {
        
        

        /*$url = "http://git.irontec.com/irontec/plantillas_documentos_presupuestos/tree/master/Plantillas/kit_bienvenida";
        
        $content= file_put_contents("../web/pdf/kit_bienvenida.pdf",file_get_contents($url));
        $nombre_usuario= 'root';
        $ruta= "../web/pdf/kit_bienvenida.pdf";
        //chown($ruta, $nombre_usuario);
        chmod("../web/pdf/kit_bienvenida.pdf", 777);
        exec('php artisan dump-autoload');
        print_r('-------------'.$content.'/n');*/

        echo $barcodeUrl  = "http://git.irontec.com/irontec/plantillas_documentos_presupuestos/tree/master/Plantillas/kit_bienvenida";
        return new Response(readfile('http://git.irontec.com/irontec/plantillas_documentos_presupuestos/tree/master/Plantillas/kit_bienvenida'), 200,array('Content-Type' => 'application/pdf'));

        /*$command = 'pdftk /var/www/html/KitMaker/web/pdf/kit_bienvenida.pdf dump_data_fields';
        $output = array();
        exec( $command , $output );

        $fieldNames = array();
        $datos = array();
        $mensage="/n Datos de acceso.";
        echo $mensage;
        foreach ($output as $key => $v) {
            $pos = strpos($v, "FieldName");
            
            if($pos !== false) {
                $auxArray = split(':', $v);
                $fieldName = trim($auxArray[1]);
                $fieldNames[$key] = $fieldName;
                echo '/n'.$fieldName;
            }   
        }

        return $this->render('KitMakerBundle:Default:index.html.twig');*/
    }

    public function bienvenidoAction(Request $request)
    {

        $command = 'pdftk /var/www/html/KitMaker/web/pdf/asardon-kit.pdf dump_data_fields';
        $output = array();
        exec( $command , $output );

        $fieldNames = array();
        $datos = array();
        $mensage="Datos de acceso.";

        foreach ($output as $key => $v) {
            $pos = strpos($v, "FieldName");
            if($pos !== false) {
                $auxArray = split(':', $v);
                $fieldName = trim($auxArray[1]);
                $fieldNames[$key] = $fieldName;
                 
            }   
        } 


            $form = $this->tarari($fieldNames);

            $request= $this->getRequest();
            if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()){
                $data = $request->getContent();
                $data =split('&', $data);
                //ksort($data.'<br>');
                foreach($data as $x => $x_value) {
                     //echo "Key=" . $x . ", Value=" . $x_value;
                     //echo "<br>";
                     $data =split('=', $x_value);
                     //print_r(str_replace("+"," ",$data[0]).'.......................'.$data[1]); 
                     echo "<br>";
                     $datos[$data[0]]= $data[1];
                      
                     echo "<br>";
                }
                
                print_r($datos);
                //print_r($data);                               
                //return $this->redirectToRoute('kit_maker_homepage');
            }
        }
    
        return $this->render('KitMakerBundle:Default:bienvenido.html.twig', array(
                'form' => $form->createView(),
                'campos'=> $fieldNames,
                'msg'=>$mensage
            ));
}
        /*$mensage="incertando un nuevo actor";
        $em= $this->getDoctrine()->getManager();
        $acteur= new Acteur();
        $form= $this->createForm(new ActeurType(), $acteur);
        $request= $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()){
                $em->persist($acteur);
                $em->flush();
                $mensage="Has incertado un nuevo actor";
                return $this->redirectToRoute('acteur_affiche');
            }
        }        
        return $this->render('pelisUserBundle:Acteur:ajout.html.twig', array('form'=>$form->createView(), 'msg'=>$mensage));*/

        /*$defaultData = array('message' => 'Type your message here'); 
        $form = $this->createFormBuilder($defaultData)  
        ->add('name', 'text')
        ->add('pass', 'text')
        ->add('message', 'textarea')
        ->add('send', 'submit')
        ->getForm();
        //$form->handleRequest($request);
        if ($form->isValid()) {
        // data es un array con claves 'name', 'email', y 'message'
            $data = $form->getData();
            return $this->redirect($this->generateUrl('kit_maker_bienvenido'));
        }
        /*$enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
        if ($form->isValid()) {
            // realiza alguna acción, como enviar un correo electrónico

            // Redirige - Esto es importante para prevenir que el usuario
            // reenvíe el formulario si actualiza la página
            return $this->redirect($this->generateUrl('kit_maker_bienvenido'));
        }
    }*/

    /*return $this->render('KitMakerBundle:Default:bienvenido.html.twig', array(
        'form' => $form->createView()
    ));*/

    public function contactAction()
{
    $command = 'pdftk /var/www/html/KitMaker/web/pdf/asardon-kit.pdf dump_data_fields';
    $output = array();
    exec( $command , $output );

    $fieldNames = array();
    $datos = array();
    $mensage="Datos de acceso.";

    foreach ($output as $key => $v) {
        $pos = strpos($v, "FieldName");
        if($pos !== false) {
            $auxArray = split(':', $v);
            $fieldName = trim($auxArray[1]);
            $fieldNames[$key] = $fieldName;
             
        }   
    }


    $enquiry = new Enquiry();
    $form = $this->createForm(new EnquiryType(), $enquiry);
    foreach ($fieldNames as $key => $value) {
        $form->add( $value, 'text')
        ->getForm();
    }

    $request = $this->getRequest();
    /*if ($request->getMethod() == 'POST') {
        //$form->bindRequest($request);
        $request= $this->getRequest();

        if ($form->isValid()) {

        $message = \Swift_Message::newInstance()
            ->setSubject('Email von IRONTEC')
            ->setFrom('agravitty@gmail.com')
            ->setTo('asardon.gmail.com')
            //->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
            ->setBody($this->renderView('KitMakerBundle:Default:contact.html.twig', array('enquiry' => $enquiry)));
            $this->get('mailer')->send($message);

        $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

        // Redirige - Esto es importante para prevenir que el usuario
        // reenvíe el formulario si actualiza la página
        return $this->redirect($this->generateUrl('kit_maker_homepage'));
    }

    }*/

    return $this->render('KitMakerBundle:Default:contact.html.twig', array(
        'form' => $form->createView(),
        'content'=> 'email desde irontec: bienvenido, con este email te mandamos el kit de bienvenida con los datos de acceso.'
    ));
}
protected function tarari ($fieldNames) {


            $form = $this->createForm(EnquiryType::class, null, array());

            foreach ($fieldNames as $key => $value) {
                if (false !== strpos(strtolower($value), 'pass')) {
                    # code...
                $form->add($key, 'password', array(
                    'label' => $value,
                    'constraints' => array(

                        ),
                    ));
                }
                else {
                $form->add($key, 'text', array(
                    'label' => $value
                    ));
                }
                # code...
            }

            return $form;

}


}
