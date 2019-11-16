<?php

namespace App;

use Nathanmac\Utilities\Parser\Parser;

class ConvertWithFreeForEx implements CurrencyConverterInterface {

    protected $parser;

    /**
     * Instantiate Parser to parse data received from third party source.
     *
     * ConvertWithFreeForEx constructor.
     */
    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * Retrieve the data from Free ForEx
     *
     * @param $from
     * @param $to
     * @return array
     */
    public function getData($from, $to)
    {
        try {
            $url = "https://www.freeforexapi.com/api/live?pairs=$from$to";

            return $this->parser->json(file_get_contents(url($url)));
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
            $url = "https://www.freeforexapi.com/api/live";

            $supportedPairs = $this->parser->json(file_get_contents(url($url)));

            $currencyList = [];

            foreach($supportedPairs['supportedPairs'] as $pair) {
                $value = str_replace(['USD', 'GBP'], '', $pair);

                if($value !== ""){
                    array_push($currencyList, $value);
                }
            }

            array_push($currencyList, 'USD', 'GBP');

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

            if ($getData['rates'][$from . $to]['rate'] > 0) {
                $exchangeRate = $getData['rates'][$from . $to]['rate'];
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
