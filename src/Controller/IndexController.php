<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

use App\Entity\Producto;
use App\Entity\Categoria;

class IndexController extends AbstractController {

    /**
     * @Route("/", name="index")
     */
    public function index() {

        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $resultado = $qb
                ->select('COUNT(p)')
                ->from('App\Entity\Producto', 'p')
                ->getQuery()
                ->getSingleScalarResult()
        ;

        dump($resultado);
        $dql = $qb->getDQL();
        $sql = $qb->getQuery()->getSQL();
        return $this->render('index/index.html.twig', [
                    'titulo' => 'Inicio',
                    'dql' => $dql,
                    'sql' => $sql,
                    'resultado' => $resultado,
        ]);
    }

}
