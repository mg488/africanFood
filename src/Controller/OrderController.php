<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @var
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
      $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande", name="order")
     */
    public function indexAction(Cart $cart): Response
    {
        if(!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('acount_address_add_new');
        }

        $form = $this->createForm(OrderType::class,null,[
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getFullCart()
        ]);
    }


    /**
     * @Route("/commande/recapitulatif", name="order_recapitulatif")
     */
    public function addOrderAction(Cart $cart, Request $request): Response
    {

        $form = $this->createForm(OrderType::class,null,[
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            //enregistrer commandes Order()
            $order = new Order();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname() .' '. $delivery->getLastname();
            $delivery_content = $delivery->getPhone();

            if($delivery->getComapny()){
                $delivery_content .= '<br/>'. $delivery->getComapny();
            }
            $delivery_content.= $delivery->getAddress();
            $delivery_content.= $delivery->getPostal().' '.$delivery->getCity();
            $delivery_content.= ' '. $delivery->getCountry();


            $order->setUser($this->getUser());
            $order->setCreateAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            //enregistrer produits Order_details()
            $orderDetails = new OrderDetails();
            foreach ($cart->getFullCart() as $product) {
//                dd($product['product']->getPrice());
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quatity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quatity']);

                $this->entityManager->persist($orderDetails);
            }
            //$this->entityManager->flush();

        }

        return $this->render('order/addOrder.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getFullCart()
        ]);
    }
}
