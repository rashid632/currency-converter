<?php

namespace App;

use Nathanmac\Utilities\Parser\Parser;

class ConvertWithFloatRates implements CurrencyConverterInterface {

    protected $parser;

    /**
     * Instantiate Parser to parse data received from third party source.
     *
     * ConvertWithFloatRates constructor.
     */
    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * Retrieve the data from Float Rates.
     *
     * @param $from
     * @param $to
     * @return array
     */
    public function getData($from, $to)
    {
        try {
            $url = "http://www.floatrates.com/daily/$from.xml";

            return $this->parser->xml(file_get_contents(url($url)));
        } catch (\Exception $ex) { // Anything that went wrong
            return [
                'message' => 'An error has occurred while obtaining data.',
                'code' => '400',
            ];
        }
    }

    /**
     * Retrieve a list of the currencies available with this provider.
     *
     * @return array
     */
    public function getCurrencyTypes(){
        try {
            $url = "http://www.floatrates.com/daily/gbp.xml";

            $supportedCurrency = $this->parser->xml(file_get_contents(url($url)));

            $currencyList = [];

            foreach($supportedCurrency['item'] as $item){
                array_push($currencyList, $item['targetCurrency']);
            }

            array_push($currencyList, 'GBP');

            sort($currencyList);

            return $currencyList;
        } catch (\Exception $ex) { // Anything that went wrong
            return [
                'message' => 'An error has occurred while retrieving currency type data.',
                'code' => '400',
            ];
        }
    }

    /**
     * Convert the currency provided.
     *
     * @param $from
     * @param $to
     * @param $amount
     * @return array|float|int
     */
    public function calculate($from, $to, $amount)
    {
        try {
            $getData = $this->getData($from, $to);

            $exchangeRate = 0;

            foreach ($getData['item'] as $item) {
                if ($item['targetCurrency'] == strtoupper($to)) {
                    $exchangeRate = $item['exchangeRate'];
                }
            }

            $convertedAmount = $exchangeRate * $amount;

            return $convertedAmount;
        } catch (\Exception $ex) { // Anything that went wrong
            return [
                'message' => 'An error has occurred calculating the exchange.',
                'code' => '400',
            ];
        }
    }
}
