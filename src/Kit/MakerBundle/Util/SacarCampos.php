<?php
namespace Kit\MakerBundle\Util;

/**
 * SacarCampos.
 */
class SacarCampos
{

	protected $session;

	public function __construct($session)
	{
		$this->session = $session;
	}

	public function sacarCampos(array $data){

	        $input = array();
	        $email = array();
	        $campos = array();	     
	        
	        if ($data != null)
	        {
				
	            $i= 0;
	            foreach ($data as $key => $value) {	               
	                if ($i<4) {
	                	$email[$key] = $value;
	            		$i++;
	                }else{
	                	$campos[$key] = $value;
	                	$i++;
	                }
	            }

	            foreach ($email as $key => $value) {	            
	                if($value == ''){
	                    return false;	                                
	                }
	                $input['email']= $email;
	            }

	            foreach ($campos as $key => $value) {	            	
	                if($value == ''){
	                    return false;	                        
	                }                        
	                $input['campos']= $campos;
	            }	            
	        }	        
	       return $input;
	}
	
}
