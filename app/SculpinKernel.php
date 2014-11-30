<?php

class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        error_reporting(error_reporting() ^ E_DEPRECATED ^ E_USER_DEPRECATED);
        return array(
            'Lonestar\Bundle\OpenCfpBundle\OpenCfpBundle'
        );
    }
}