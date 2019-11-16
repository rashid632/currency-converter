<?php

namespace App\Http\Controllers;

use App\CurrencyConverterInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    protected $currencyConverter;

    /**
     * CurrencyController constructor.
     * @param CurrencyConverterInterface $currencyConverter
     */
    public function __construct(CurrencyConverterInterface $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @return mixed
     */
    public function getCurrencyTypes(){
        return $this->currencyConverter->getCurrencyTypes();
    }

    /**
     * Validate the request, ensure the 'from' and 'to' variables are uppercase;
     * then pass it on to the currency converter calculator to calculate
     * the exchange.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function convert(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'from' => 'required|string|min:3|max:3',
            'to' => 'required|string|min:3|max:3',
            'amount' => 'required|numeric',
        ]);

        if ($validation->fails())
        {
            return response()->json(['errors'=>$validation->errors()]);
        }

        $from = strtoupper($request->from);
        $to = strtoupper($request->to);
        $amount = $request->amount;

        return $this->currencyConverter->calculate($from, $to, $amount);
    }
}
