<?php

namespace Webkul\Vapulus\Payment;

use Webkul\Payment\Payment\Payment;

/**
 * VapulusPayment method class
 *
 * @author    Vivek Sharma <viveksh047@webkul.com> @vivek-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class VapulusPayment extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'vapulus';

    /**
     * Get the redirect url for redirecting to
     */
    public function getRedirectUrl()
    {
        return route('vapulus.payment.redirect');
    }

    /**
     * Vapulus web URL generic getter
     *
     * @param array $params
     * @return string
     */
    public function getVapulusUrl($params = [])
    {
        $this->getRedirectUrl();
    }

    /**
     * Returns payment method title
     *
     * @return array
     */
    public function getTitle()
    {
        return $this->getConfigData('title') ? $this->getConfigData('title') : 'Vapulus';
    }

    /**
     * Returns payment method description
     *
     * @return array
     */
    public function getDescription()
    {
        return $this->getConfigData('description') ? $this->getConfigData('description') : 'Vapulus Pay';
    }

    /**
     * Retrieve information from payment configuration
     *
     * @param  string  $field
     * @param  int|string|null  $channelId
     * @return mixed
     */
    public function getConfigData($field)
    {
        return core()->getConfigData('sales.paymentmethods.' . $this->getCode() . '.' . $field);
    }
}