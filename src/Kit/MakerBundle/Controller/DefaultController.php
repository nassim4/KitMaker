<?php

namespace Kit\MakerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kit\MakerBundle\Entity\Enquiry;
use Kit\MakerBundle\Form\EnquiryType;
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $this->downloadFile();

        $service = $this->get('kit_maker.bajar_pdf');
        $fieldNames = $service->bajar();

        $mensage= 'añadir los datos.';
        return $this->render('KitMakerBundle:Default:formulario.html.twig', array(
                    'campos' => $fieldNames,
                    'content'=> 'email desde irontec: bienvenido, con este email te mandamos el kit de bienvenida con los datos de acceso.',
                    'msg' => $mensage));
        
    }

    public function bienvenidoAction(Request $request)
    {       
        $session = $this->get('session');

        //$data = $form->getData();
        //$data is an instance of SMTC\MainBundle\Model\Task
        /*$input = array();
        $email = array();
        $campos = array();*/
        $content= '';
        $mensage= '';
        $data= $request->request->all();
        /*echo "11111111111111111111111111111111111111111"."<br>";
        print_r($data);*/
        
        if ('POST' === $request->getMethod())
        {
            $service = $this->get('kit_maker.sacarCampos_pdf');
            $data = $service->sacarCampos($request->request->all());
            if (false === $data) {
                $mensage= 'le falta algun campo para rellenar';
                
                $content= $this->redirectToRoute('kit_maker_homepage', array(
                         'msg' => $mensage
                         ));

            }
            else
            {
 
                $email= $data['email'];
                /*foreach ($email as $key => $value) 
                {
                    print_r('$email-----'.$key.'</br>');
                    print_r('$email-----'.$value.'</br>');
                }*/                       
                $campos= $data['campos'];
                /*foreach ($campos as $key => $value) 
                {
                    print_r('$campos-----'.$key.'</br>');
                    print_r('$campos-----'.$value.'</br>');
                }*/
                //echo "todo esta bien";

                //echo "55555555555555555555555555555555555555"."<br>";

                $service = $this->get('kit_maker.generar_pdf');
                $data = $service->GenerarPDF($campos);
                if ($data== '0') 
                {
                    $mensage= 'No se ha generado el pdf correctamente.';
                }else
                {
                    $mensage= 'se ha generado el pdf correctamente.';
                }

                //$this->addFlash('info', 'The item was created successfully.');
                $service = $this->get('kit_maker.mandarEmail');
                $data = $service->mandarEmail($email);

                /*$message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject($email['_usersubject'])
                ->setFrom('agravitty@gmail.com')
                ->setTo($email['_useremail'])
                ->setBody($email['_userbody']);

                $this->get('swiftmailer')->send($message);*/
                $mensage= 'se han mandado los datos correctamente.';
                return $this->render('KitMakerBundle:Default:bienvenido.html.twig', array(
                         'msg' => $mensage
                         ));
                 //$content= $this->redirectToRoute('kit_maker_bienvenido');

            }  

        }  //return new Response($content);                    
    }   
    protected  function base64ToJpeg( $base64_string, $output_file ) 
    {
            $ifp = fopen( $output_file, "wb" ); 
            fwrite( $ifp, base64_decode( $base64_string) ); 
            fclose( $ifp ); 
            return( $output_file ); 
    }
    protected function downloadFile()
    {
        /*$command = 'pdftk /var/www/html/KitMaker/web/pdf/Kit_Bienvenida.pdf dump_data_fields';  AllowEncodedSlashes NoDecode
        $output = array();
        exec( $command , $output );*/
        
        
        $api = $this->get('gitlab_api');
        $arrayFile = $api->api('repo')->getFile('229', 
            'Plantillas/kit_bienvenida/Kit_Bienvenida.pdf',
            'master' 
        );

        //$logger = $this->get('logger');

        //$logger->info( "<br>//////////Nombre des files//////////////   ");
        $file_name= $arrayFile['file_name'];
        //print_r($arrayFile['file_name']);
        //echo "<br>//////////Encoding des files//////////////   ";
        $encoding= $arrayFile['encoding'];
        //print_r($arrayFile['encoding']);
        //echo "<br>//////////Content des files//////////////   ";
        $content= $arrayFile['content'];
        //print_r($arrayFile['content']);
        //chmod($content, 0777);
        //echo "<br>---------------decoding file------------";
        //$file= base64_decode($content);


        $file = $this->base64ToJpeg( $content, '/var/www/html/KitMaker/src/Kit/MakerBundle/Util/pdf/Bienvenido.pdf' );
        //print_r($file);
        //$file= base64_decode(str_replace(array('-', '_'), array('+', '/'), $content));
        //$file = str_replace(' ','+',$content);
        //echo "<br>---------------decoding file------------";
        //print_r($file);
        /*$command = 'pdftk '.$file.' dump_data_fields';
        $output = array();
        exec( $command , $output );
        echo "<br>---------------Output------------";
        print_r($output);
        echo "222222222222222222222222222222222222222222";
        foreach ($output as $key => $value) {
            print_r($key.'...br>');
            print_r($value.'...br>');
        }*/
        //return $output;

        //chmod($file, 0777);
        // Coger file convertirlo en un array
        // Coger la clave content de $file y decodificarla con base_64
        //echo "333333333333333333333333333333333333333333333";
        //var_dump($issues);
        //die();
    }
}
