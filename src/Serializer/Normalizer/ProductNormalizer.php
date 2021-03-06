<?php

namespace App\Serializer\Normalizer;

use App\Entity\Product;
use ArrayObject;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class ProductNormalizer implements  NormalizerInterface
{
    /**
     * @var ObjectNormalizer
     */
    private ObjectNormalizer $objectNormalizer;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $router;


    /**
     * ProductNormalizer constructor.
     * @param ObjectNormalizer $objectNormalizer
     * @param UrlGeneratorInterface $router
     */
    public function __construct(
        ObjectNormalizer $objectNormalizer,
        UrlGeneratorInterface $router
    )
    {
        $this->objectNormalizer = $objectNormalizer;
        $this->router = $router;
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $context['ignored_attributes'] = ['savedProducts'];

        $data = (array) $this->objectNormalizer->normalize($object, $format, $context);
        $data['href']['self'] = $this->router->generate('api_get_one_product', ['id' => $object->getId()]);

        return $data;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Product;
    }
}
