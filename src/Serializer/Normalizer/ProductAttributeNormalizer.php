<?php

namespace App\Serializer\Normalizer;

use App\Entity\Product;
use App\Entity\ProductAttribute;
use ArrayObject;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class ProductAttributeNormalizer implements NormalizerInterface
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
     * @return array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'value' => $object->getValue()
        ];
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof ProductAttribute;
    }
}

