<?php

declare(strict_types=1);

namespace PetitPress\GpsMessengerBundle\Tests\DependencyInjection;

use PetitPress\GpsMessengerBundle\DependencyInjection\PetitPressGpsMessengerExtension;
use PetitPress\GpsMessengerBundle\Transport\GpsTransportFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Parser;

class PetitPressGpsMessengerExtensionTest extends TestCase
{
    public function testSimpleConfiguration(): void
    {
        $configuration = new ContainerBuilder();
        $loader = new PetitPressGpsMessengerExtension();
        $config = $this->getSimpleConfig();
        $loader->load([$config], $configuration);

        static::assertTrue($configuration->hasDefinition(GpsTransportFactory::class));
        $gpsTransportFactoryDefinition = $configuration->getDefinition(GpsTransportFactory::class);
        $cacheArgument = $gpsTransportFactoryDefinition->getArgument(1);
        static::assertInstanceOf(Reference::class, $cacheArgument);
        static::assertEquals('cache.app', (string) $cacheArgument);
    }

    /**
     * @return mixed
     */
    private function getSimpleConfig()
    {
        // use all defaults
        return (new Parser())->parse('');
    }

    public function testFullConfiguration(): void
    {
        $configuration = new ContainerBuilder();
        $loader = new PetitPressGpsMessengerExtension();
        $config = $this->getFullConfig();
        $loader->load([$config], $configuration);

        static::assertTrue($configuration->hasDefinition(GpsTransportFactory::class));
        $gpsTransportFactoryDefinition = $configuration->getDefinition(GpsTransportFactory::class);
        $cacheArgument = $gpsTransportFactoryDefinition->getArgument(1);
        static::assertInstanceOf(Reference::class, $cacheArgument);
        static::assertEquals('foo', (string) $cacheArgument);
    }

    /**
     * @return array<string, mixed>
     */
    private function getFullConfig(): array
    {
        $yaml = <<<EOF
auth_cache: 'foo'
EOF;
        /** @var array<string, mixed> */
        return (new Parser())->parse($yaml);
    }


    public function testConfigurationWithDisabledAuthCache(): void
    {
        $configuration = new ContainerBuilder();
        $loader = new PetitPressGpsMessengerExtension();
        $config = $this->getDisabledCacheConfig();
        $loader->load([$config], $configuration);

        static::assertTrue($configuration->hasDefinition(GpsTransportFactory::class));
        $gpsTransportFactoryDefinition = $configuration->getDefinition(GpsTransportFactory::class);
        static::assertNull($gpsTransportFactoryDefinition->getArgument(1));
    }

    /**
     * @return mixed
     */
    private function getDisabledCacheConfig()
    {
        $yaml = <<<EOF
auth_cache: false
EOF;

        return (new Parser())->parse($yaml);
    }
}
