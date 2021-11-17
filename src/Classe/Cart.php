<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart{

    /**
     * @var
     */
    private $session;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param SessionInterface $session
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(SessionInterface $session,EntityManagerInterface $entityManager){
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     */
    public function addProductToCart($id)
    {
        //si cat est null alors envoie un tableau vide []
        $cart = $this->session->get('cart',[]);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }
        else{
            $cart[$id]=1;
        }

        $this->session->set('cart',$cart);
    }


    /**
     * @return mixed
     */
    public function getCart(){
        return $this->session->get('cart');
    }

    /**
     * @return mixed
     */
    public function removeProductToCart(){
       return $this->session->remove('cart');

    }

    /**
     * @return mixed
     */
    public function deleteProductInCartAction($id){

       $cart = $this->session->get('cart');
       unset($cart[$id]);

       return $this->session->set('cart',$cart);
    }

    /**
     * @param $id
     */
    public function decreaseProductQuantity($id)
    {
        //si cat est null alors envoie un tableau vide []
        $cart = $this->session->get('cart',[]);

        if(!empty($cart[$id]) && $cart[$id]==1){
            unset($cart[$id]);
        }

        if(!empty($cart[$id])){
            $cart[$id]--;
        }

        return $this->session->set('cart',$cart);
    }


    /**
     * @return array
     */

    public function getFullCart(): array
    {
        $cartComplete =[];

        if (!empty($this->getCart())){
            foreach($this->getCart() as $id =>$quantity){

                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);
                if(!$product_object){
                    $this->deleteProductInCartAction($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' =>$product_object,
                    'quatity'=>$quantity
                ];
            }
        }
        return $cartComplete;
    }



}