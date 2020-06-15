<?php

namespace Eleanorsoft\CanonicalUrl\Helper;

use Magento\Backend\Helper\Data as BackendHelper;
use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * Module general config.
 *
 * @package Eleanorsoft\Instagram\Model
 * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
 * @copyright Copyright (c) 2020 EleanorSoft (https://www.eleanorsoft.com/)
 *
 * todo backend helper
 */
class Config extends AbstractHelper
{
    /**
     * Module name.
     */
    const MODULE_NAME = 'eleanorsoft_caconical';

    /**
     * Config canonical domain.
     */
    const CANONOCAL_DOAMIN = 'canonical_domain';

    /**
     * Config default group value.
     */
    const DEFAULT_GROUP = 'general';

    /**
     * Config section value.
     */
    const SECTION = 'eleanorsoft_canonical';

    /**
     * @var string
     */
    protected $storeId;

    /**
     * @var string
     */
    protected $storeScope;

    /**
     * @var BackendHelper
     */
    protected $backendHelper;

    /**
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * @var ReinitableConfigInterface
     */
    protected $reinitableConfig;

    /**
     * Config constructor.
     *
     * @param Context $context
     * @param WriterInterface $configWriter
     * @param ReinitableConfigInterface $reinitableConfig
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        BackendHelper $backendHelper,
        WriterInterface $configWriter,
        ReinitableConfigInterface $reinitableConfig
    ) {
        $this->configWriter = $configWriter;
        $this->backendHelper = $backendHelper;
        $this->reinitableConfig = $reinitableConfig;

        parent::__construct($context);
        $this->_construct();
    }

    /**
     * Helper pseudo construct.
     *
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function _construct()
    {
        $this->setStoreId(null);
    }

    /**
     * Get store id.
     *
     * @return string
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Get store scope.
     *
     * @return string
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getStoreScope()
    {
        return $this->storeScope;
    }

    /**
     * Set store id.
     *
     * @param $storeId
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        $this->storeScope = $this->getStoreId() ?
            ScopeInterface::SCOPE_STORES :
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
    }

    /**
     * Delete canonical url.
     *
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function deleteCanonicalUrl()
    {
        $this->deleteByPath($this->getCanonicalUrlPath());
    }

    /**
     * Get config canonical url.
     *
     * @return string
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getCanonicalUrlPath()
    {
        return $this->getPath(self::CANONOCAL_DOAMIN);
    }

    /**
     * Get config canonical url.
     *
     * @return mixed
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getCanonicalUrlValue()
    {
        return trim($this->getValue($this->getCanonicalUrlPath()), '/ ');
    }

    /**
     * Set config canonical url.
     *
     * @param $value
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function setCanonicalUrlValue($value)
    {
        $this->setValue($this->getCanonicalUrlPath(), $this->getClearedString($value));
    }

    /**
     * Get config value.
     *
     * @param $path
     * @return mixed
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getValue($path)
    {
        return $this->scopeConfig->getValue($path, $this->getStoreScope(), $this->getStoreId());
    }

    /**
     * Set config value.
     *
     * @param $path
     * @param $value
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function setValue($path, $value)
    {
        $this->configWriter->save($path, $value, $this->getStoreScope(), $this->getStoreId());
    }

    /**
     * Delete config value.
     *
     * @param $path
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function deleteByPath($path)
    {
        $this->configWriter->delete($path, $this->getStoreScope(), $this->getStoreId());
    }

    /**
     * Get config path.
     *
     * @param $value
     * @param string $group
     * @return string
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getPath($value, $group = self::DEFAULT_GROUP)
    {
        return self::SECTION . "/$group/$value";
    }

    /**
     * Refresh config data.
     *
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function refreshConfig()
    {
        $this->reinitableConfig->reinit();
    }

    /**
     * Get cleared string
     *
     * @param $string
     * @return string
     * @author Dmitry Vernigora <dmitry.vernigora@eleanorsoft.com>
     */
    public function getClearedString($string)
    {
        return trim($string);
    }
}
