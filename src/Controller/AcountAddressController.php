<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcountAddressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="acount_address")
     */
    public function indexAction(): Response
    {

        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="acount_address_add_new")
     */
    public function addNewAddressAction(): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class,$address);
        return $this->render('account/address_add_new.html.twig',[
        'form'=>$form->createView()
        ]);
    }
}
