<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;

    }


    /**
     * @Route("/panier/mon-panier", name="cart")
     */
    public function indexAction(Cart $cart): Response
    {
        if(empty($cart->getCart())){
            return $this->redirectToRoute('products');
        }

        return $this->render('cart/index.html.twig',[
            'cart'=>$cart->getFullCart()
        ]);
    }

    /**
     * @Route("/panier/ajouter/{id}", name="add_to_cart")
     */
    public function addAction(Cart $cart,$id): Response
    {

        $cart->addProductToCart($id);

        return $this->redirectToRoute('cart');
    }


    /**
     **pour supprimer le panier entier
     *
     *
     * @Route("/panier/supprimer", name="remove_my_cart")
     */
    public function removeAction(Cart $cart): Response
    {
        $cart->removeProductToCart();

        return $this->redirectToRoute('products');
    }


    /**
     ** supprimer un produit du panier
     *
     *
     * @Route("/panier/supprimer/{id}", name="delete_product_to_cart")
     */
    public function deleteProductAction(Cart $cart,$id): Response
    {

        $cart->deleteProductInCartAction($id);

        return $this->redirectToRoute('cart');
    }


    /**
     * @Route("/panier/diminuer/{id}", name="decrease_product_quantity")
     */
    public function decreaseAction(Cart $cart,$id): Response
    {
        $cart->decreaseProductQuantity($id);

        return $this->redirectToRoute('cart');
    }

}
