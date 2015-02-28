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
use Michelf\Markdown;

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
        $this->baseUrl = 'http://api.lonestarphp.com';
    }

    public function dataSourceId() {
        return "OpenCfpDataSource:URLHERE";
    }

    public function refresh(SourceSet $sourceSet) {
        $sinceTimeLast = $this->sinceTime;
        $this->sinceTime = date('c');

        $newConfig = $this->siteConfigurationFactory->create();
        $newConfig->set('opencfp', [
            'sponsors' => $this->getSponsors(),
            'talks' => $this->getTalks(),
            'speakers' => $this->getSpeakers(),
        ]);

        $this->siteConfiguration->import($newConfig);
    }

    /**
     * Get Sponsors List from API
     * @return array
     */
    public function getSponsors()
    {
        $json = (new \Guzzle\Http\Client($this->baseUrl))
            ->get('/sponsors')
            ->send()
            ->json();

        $json = array_map(function($sponsor) {
            $sponsor['description'] = Markdown::defaultTransform($sponsor['description']);

            return $sponsor;
        }, $json);

        return $json;
    }

    /**
     * Get Speakers List from API
     * @return array
     */
    public function getSpeakers()
    {
        $json = (new \Guzzle\Http\Client($this->baseUrl))
            ->get('/speakers')
            ->send()
            ->json();

        $json = array_map(function($speaker) {
            $speaker['bio'] = Markdown::defaultTransform($speaker['bio']);

            return $speaker;
        }, $json);

        return $json;
    }

    /**
     * Get Talks List from API
     * @return array
     */
    public function getTalks()
    {
        $json = (new \Guzzle\Http\Client($this->baseUrl))
            ->get('/talks')
            ->send()
            ->json();

        $json = array_map(function($talk) {
            $talk['abstract'] = Markdown::defaultTransform($talk['abstract']);

            return $talk;
        }, $json);

        return $json;
    }
}