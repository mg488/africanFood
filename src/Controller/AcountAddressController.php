<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcountAddressController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager=$entityManager;
    }
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
    public function addNewAddressAction(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class,$address);

        $form=$form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $address = $form->getData();
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            return $this->redirectToRoute('acount_address');
        }
        return $this->render('account/address_form_new.html.twig',[
        'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="acount_address_edit")
     */
    public function editAddressAction(Request $request, $id): Response
    {

        $address= $this->entityManager->getRepository(Address::class)->findOneById($id);

        if(!$address || $address->getUser()!=$this->getUser()){
            return $this->redirectToRoute('acount_address');
        }

        $form =$this->createForm(AddressType::class,$address);
        //lamis àjour est faite directement avec le handleRequest
        $form=$form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->entityManager->flush();
            return $this->redirectToRoute('acount_address');
        }
        return $this->render('account/address_form_new.html.twig',[
        'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="acount_address_delete")
     */
    public function deleteAddressAction($id): Response
    {

        $address= $this->entityManager->getRepository(Address::class)->findOneById($id);

        if($address && $address->getUser()==$this->getUser()){
            $this->entityManager->remove($address);
            $this->entityManager->flush();
            return $this->redirectToRoute('acount_address');
        }
        return $this->redirectToRoute('acount_address');
    }

}
