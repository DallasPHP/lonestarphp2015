<?php

namespace Lonestar\Bundle\OpenCfpBundle;

use Sculpin\Core\Source\DataSourceInterface;
use Dflydev\DotAccessConfiguration\ConfigurationInterface;
use Dflydev\Symfony\FinderFactory\FinderFactory;
use Dflydev\Symfony\FinderFactory\FinderFactoryInterface;
use dflydev\util\antPathMatcher\AntPathMatcher;
use Sculpin\Core\SiteConfiguration\SiteConfigurationFactory;
use Sculpin\Core\Source\SourceSet;
use Sculpin\Core\Source\MemorySource;

class OpenCfpDataSource implements DataSourceInterface {

    /**
     * Constructor.
     *
     * @param ConfigurationInterface   $siteConfiguration        Site Configuration
     * @param SiteConfigurationFactory $siteConfigurationFactory Site Configuration Factory
     * @param FinderFactoryInterface   $finderFactory            Finder Factory
     * @param AntPathMatcher           $matcher                  Matcher
     */
    public function __construct(
        ConfigurationInterface $siteConfiguration,
        SiteConfigurationFactory $siteConfigurationFactory,
        FinderFactoryInterface $finderFactory = null,
        AntPathMatcher $matcher = null
    ) {
        $this->siteConfiguration = $siteConfiguration;
        $this->siteConfigurationFactory = $siteConfigurationFactory;
        $this->finderFactory = $finderFactory ?: new FinderFactory;
        $this->matcher = $matcher ?: new AntPathMatcher;
        $this->sinceTime = '1970-01-01T00:00:00Z';
    }

    public function dataSourceId() {
        return "OpenCfpDataSource:URLHERE";
    }

    public function refresh(SourceSet $sourceSet) {
        $sinceTimeLast = $this->sinceTime;
        $this->sinceTime = date('c');

        $mockData = [
            [
                'name' => 'Daniel Cousineau',
                'country' => 'USA',
                'twitter' => '@dcousineau',
            ],
            [
                'name' => 'Daniel Cousineau',
                'country' => 'USA',
                'twitter' => '@dcousineau',
            ]
        ];

        $newConfig = $this->siteConfigurationFactory->create();
        $newConfig->set('opencfp', [
            'speakers' => $mockData
        ]);

        $this->siteConfiguration->import($newConfig);
    }
}