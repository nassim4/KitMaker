<?php

namespace Kit\MakerBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints as Assert;


class Enquiry
{
    /**
     * @Assert\NotBlank()
     *
     * @var type 
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string 
     */
    protected $email;

    /**
     *
     * @var type 
     */
    protected $subject;

    protected $body;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }
    

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {   
        $metadata->addPropertyConstraint('email', new Email());
        $metadata->addPropertyConstraint('subject', new NotBlank());
        $metadata->addPropertyConstraint('name', new NotBlank());
        $metadata->addPropertyConstraint('body', new NotBlank());

        $metadata->addPropertyConstraint('email', new Email(array(
                'message' => 'email no valido!'
        )));
        $metadata->addPropertyConstraint('subject', new NotBlank(array(
                'message' => 'el subject no puede estar vacio!'
        )));
        $metadata->addPropertyConstraint('name', new NotBlank(array(
                'message' => 'el name no puede estar vacio!'
        )));
        $metadata->addPropertyConstraint('body', new NotBlank(array(
                'message' => 'el body no puede estar vacio!'
        )));      
    }

    


}