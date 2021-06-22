<?php


namespace App\Serializer;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CircularReferenceHandler
{
    /**
     * @var
     */
    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke($object)
    {
        switch ($object) {
            case $object instanceof Product:
                return $this->router->generate('api_get_one_product', ['id' => $object->getId()]);
            case $object instanceof Category:
                return $this->router->generate('api_get_one_category', ['id' => $object->getId()]);
            case $object instanceof  User:
                return $this->router->generate('api_get_one_user', ['id' => $object->getId()]);
        }

        return $object->getId();
    }
}