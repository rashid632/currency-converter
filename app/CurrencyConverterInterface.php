<?php

namespace App;

interface CurrencyConverterInterface
{

    /**
     * Retrieve data from a provider.
     *
     * @param $from
     * @param $to
     * @return mixed
     */
    public function getData($from, $to);

    /**
     * Retrieve a list of currencies supported by a provider.
     *
     * @return mixed
     */
    public function getCurrencyTypes();

    /**
     * Calculate the conversion from the base currency to the target currency.
     *
     * @param $from
     * @param $to
     * @param $amount
     * @return mixed
     */
    public function calculate($from, $to, $amount);
}
