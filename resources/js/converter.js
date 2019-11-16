$( document ).ready(function() {

    /*
     * Store the bearer token in session.
     *
     * */
    sessionStorage.setItem('bearerToken', JSON.stringify('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFiZDRiYzAxMzJjZWE0Nzg1ZTAxZTQwZDJhOTA5ODNjNWQyYzk5OWM4MzI3ODFmYWEwZGJjNjZkNjU2NDJiOGYyYTBkZWVhZTdjY2M0NzFmIn0.eyJhdWQiOiIyIiwianRpIjoiYWJkNGJjMDEzMmNlYTQ3ODVlMDFlNDBkMmE5MDk4M2M1ZDJjOTk5YzgzMjc4MWZhYTBkYmM2NmQ2NTY0MmI4ZjJhMGRlZWFlN2NjYzQ3MWYiLCJpYXQiOjE1NzM4NjI4NTQsIm5iZiI6MTU3Mzg2Mjg1NCwiZXhwIjoxNjA1NDg1MjU0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.jYR942d3G-5hbZRdB-71_veiGijDkB28mmeptRi4EsHDueD6x4emYgtlLCmgnkGfEQr-Af7LDBqvxHBvGdlmKpekGwawszO2USIosDzY17XTk0m8UFmbL5vZ6vS8RlzLrs61nJqkO8Lz-EnzN3xBveSSytvIrrjzzmGYiyDig1juWDI1rwrHHZ1hqABTWbjdz_QeT5fL8qp9zZVQDJHCw05Wp42GmoaOwaOmUiYfv07uTCRi8MmW74TSIm9Msc1YeLQOiGEsGU3yMpa_skMGmu4NHvo_ZiLEti3MSiIQvPp0NI6gdsynqHIHzALcx50k-T4gc83jE2TIqhXlihqrB7UzjNYrKR7LUPmoIXMJltRD4uIE-XEUJbL2zm1WtHy7PuxzWtdq-p9DigCCiA_LqEMlhhWY-evO7j0_iNME_RFKpUNhtnEeLoSvEXLHKLdYVCVPb_GdXADORgQ517XxBMsFtWIn3utN_LajJvRDLXTCLXoe_8ompyg_BDDENmfjBoo-0SXj-Lt1PpF3Bw-rOv99bX-yhu17-bbcvK6l5Glw1Xz9mnkeL54IsWBPGpuM6bmhPfdXBRCCIJgM-jz4QfHLTfiKGDkbKZyx5B5LZnQr1oX_GnxzwybAcBgtgnjXKKhMGxH3yKkWHldmGzUt3if3zuCn5rRrpl8G3Ls5ZTo'));

    /*
    * Define selectors
    *
    * */
    var $selectBaseCurrency = $("#selectBaseCurrency");
    var $selectTargetCurrency = $("#selectTargetCurrency");
    var $baseCurrencyAmount = $("#baseCurrencyAmount");
    var $btnConvert = $("#btnConvert");

    var $errorContainer = $(".converter .errors");
    var $errorBody = $(".converter .errors .body");

    var $resultContainer = $(".converter .result");
    var $resultBody = $(".converter .result .body");

    /*
    * Retrieve token from session
    *
    * */
    var $token = JSON.parse(sessionStorage.getItem('bearerToken'));

    /*
    * On page load, run an ajax request to retrieve a list of all the
    * currencies which can be converted. Pass through the token
    * for authentication
    *
    * */
    $.get({
        url: '/api/v1/getCurrencyTypes',
        headers: {
            'Authorization': `Bearer ${$token}`,
        },
    }).done(function(data) {

        /*
        * Validation: If an error is returned from the Laravel API, then display an error to the user.
        *
        * */
        if(data.code && data.code === '400') {
            $errorBody.html('Sorry, we are unable to retrieve currencies.');

            $resultContainer.hide();

            $errorContainer.show();

            return;
        }

        /*
        * If validation passes, populate the dropdown menus with the currencies and enable the fields.
        *
        * */
        $.each(data, function() {
            $selectBaseCurrency
                .append($("<option />")
                    .val(this).text(this))
                .prop("disabled", false);

            $selectTargetCurrency
                .append($("<option />")
                    .val(this).text(this))
                .prop("disabled", false);

            $baseCurrencyAmount
                .prop("disabled", false)
                .focus();

            $btnConvert.prop("disabled", false);
        });


    }).fail(function(jqXHR, textStatus, errorThrown) {
        /*
        * On failure log error information.
        *
        * */
        console.log(textStatus + ': ' + errorThrown);
    });

    /*
    * On submit button click.
    *
    * */
    $btnConvert.click(function() {

        /*
        * Declare variables.
        *
        * */
        var $selectBaseCurrencyValue = $selectBaseCurrency.find(":selected").val();
        var $selectTargetCurrencyValue = $selectTargetCurrency.find(":selected").val();
        var $baseCurrencyAmountValue = $baseCurrencyAmount.val();

        var $targetCurrencyAmountValue;
        var $errorMessage = "";
        var $resultMessage = "";

        /*
        * Hide result and error container if they have been shown.
        *
        * */
        $resultContainer.hide();

        $errorContainer.hide();

        /*
        * Execute the GET ajax request to convert the currency.
        *
        * */
        $.get({
            url: '/api/v1/convert?from=' + $selectBaseCurrencyValue + '&to=' + $selectTargetCurrencyValue + '&amount=' + $baseCurrencyAmountValue,
            headers: {
                'Authorization': `Bearer ${$token}`,
            },
        }).done(function(data) {

            /*
            * Validation: check for errors returned by the Laravel API.
            *
            * */
            if(data.errors){
                $.each(data.errors, function( index, value ) {
                    $errorMessage += value[0] + '<br>';
                });

                $errorBody.html($errorMessage);

                $errorContainer.show();

                return;
            }

            if(data.code && data.code === '400') {
                $errorBody.html(data.message);

                $errorContainer.show();

                return;
            }

            /*
            *
            * If validation passes, show the results.
            *
            * */

            /*
            * Convert the currencies to 2 decimal places.
            *
            * */
            $baseCurrencyAmountValue = parseFloat($baseCurrencyAmountValue).toFixed(2);
            $targetCurrencyAmountValue = parseFloat(data).toFixed(2);

            /*
            * Build and show the success result message.
            *
            * */
            $resultMessage = $baseCurrencyAmountValue + $selectBaseCurrencyValue + ' = ' + $targetCurrencyAmountValue + $selectTargetCurrencyValue;

            $resultBody.html($resultMessage);

            $resultContainer.show();

        }).fail(function(jqXHR, textStatus, errorThrown) {

            /*
            * Execute the GET ajax request to convert the currency.
            *
            * */
            console.log(textStatus + ': ' + errorThrown);
        });
    });
});
