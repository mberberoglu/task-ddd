<?php

namespace App\Infrastructure\Common\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use JMS\Serializer\Serializer;

/**
 * Class JsonDocumentType.
 */
class JsonDocumentType extends Type
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var Serializer
     */
    private $serializer;

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function setSerializer(Serializer $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $this->getSerializer()->serialize($value, 'json');
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $this->getSerializer()->deserialize($value, $this->type, 'json');
    }

    /**
     * @return string
     */
    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'JSON';
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'JSON';
    }
}
