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

class ProductNormalizer implements  NormalizerInterface
{
    /**
     * @var ObjectNormalizer
     */
    private ObjectNormalizer $objectNormalizer;

    /**
     * ProductNormalizer constructor.
     * @param ObjectNormalizer $objectNormalizer
     */
    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|mixed|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'price' => $object->getPrice(),
            'techCondition' => $object->getTechCondition(),
            'createdAt' => $object->getCreatedAt(),
            'description' => $object->getDescription(),
            'category' => ['categoryName' => $object->getCategory()->getTitle(), 'id' => $object->getCategory()->getId()],
            'user' => ['userName' => $object->getUser()->getUserName(), 'id' => $object->getUser()->getId()]
        ];
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
