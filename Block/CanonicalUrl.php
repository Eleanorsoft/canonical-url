<?php

namespace Eleanorsoft\CanonicalUrl\Block;

use Eleanorsoft\CanonicalUrl\Helper\Config;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class CanonicalUrl
 * Block for displaying canonical URL tag.
 *
 * @package Eleanorsoft\CanonicalUrl
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2020 EleanorSoft (https://www.eleanorsoft.com/)
 */
class CanonicalUrl extends Template
{
    /**
     * @var Config
     */
    private $helper;

    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * CanonicalUrl constructor.
     * @param Template\Context $context
     * @param UrlInterface $urlInterface
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        UrlInterface $urlInterface,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $config;
        $this->urlInterface = $urlInterface;
    }

    /**
     * If canonical tag should be shown.
     * There should be some URL set in configuration and
     * current requested does not start with canonical base url
     * @return bool
     */
    public function canShow()
    {
        if (!!$this->helper->getCanonicalUrlValue()) {
            if (stripos($this->urlInterface->getCurrentUrl(), $this->helper->getCanonicalUrlValue()) !== 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Full value of canonical URL including REQUEST URI
     * @return string
     */
    public function getCanonicalUrl()
    {
        return $this->helper->getCanonicalUrlValue() . $this->_request->getRequestUri();
    }
}
