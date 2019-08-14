<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\CategoriaRepository;
use App\Entity\Producto;
use App\Entity\Categoria;

class AppFixtures extends Fixture {

    /**
     *
     * @var ObjectManager
     */
    private $manager;

    /**
     *
     * @var CategoriaRepository
     */
    private $repositoryCategoria;

    public function load(ObjectManager $manager) {
        $this->manager = $manager;
        $this->repositoryCategoria = $manager->getRepository(Categoria::class);
        
        $this->_createCategoria("Eléctricos");
        $this->_createCategoria("Color");
        
        $this->_createProducto('Secador Pro', 99990, 'Eléctricos');
        $this->_createProducto('Tintura Socolor', 4990, 'Color');
        $this->_createProducto('Plancha Alisadora', 54990, 'Eléctricos');
    }

    private function _createCategoria(string $nombre, bool $persistir = true): Categoria {
        $categoria = (new Categoria())
                ->setNombre($nombre)
        ;
        
        if($persistir) {
            $this->_persistir($categoria);
        }
        
        return $categoria;
    }

    private function _createProducto(string $nombre, float $precio, string $categoriaString, bool $persistir = true): Producto {
        $categoria = $this->repositoryCategoria->findOneBy(['nombre' => $categoriaString]);

        $producto = (new Producto())
                ->setNombre($nombre)
                ->setPrecio($precio)
                ->setCategoria($categoria)
        ;

        if ($persistir) {
            $this->_persistir($producto);
        }

        return $producto;
    }

    private function _persistir($objeto): void {
        $this->manager->persist($objeto);
        $this->manager->flush();
    }

}
