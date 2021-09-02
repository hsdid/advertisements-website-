<?php

namespace App\Serializer\Normalizer;

use App\Entity\Category;
use ArrayObject;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CategoryNormalizer implements NormalizerInterface
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
        $context['ignored_attributes'] = ['parent', 'products'];

        $data = (array) $this->objectNormalizer->normalize($object, $format, $context);
        $data['href']['self'] = $this->router->generate('api_get_one_category', ['id' => $object->getId()]);

        return $data;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Category;
    }
}
