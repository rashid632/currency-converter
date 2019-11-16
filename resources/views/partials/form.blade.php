<div class="container form">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7 col-lg-5">
        {{ Form::open(['url' => 'foo/bar']) }}
        <!--- baseCurrency amount Field --->
            <div class="form-group">
                {!! Form::text('Base Currency', null, [
                    'id' => 'baseCurrencyAmount',
                    'class' => 'form-control col-12',
                    'disabled' => 'disabled',
                    'placeholder' => 'Enter Amount'
                ]) !!}
            </div>

            <div class="form-group">
                <div class="col-12 text-center">
                    <!--- baseCurrency select Field --->
                {!! Form::select('from', [], null, [
                    'id' => 'selectBaseCurrency',
                    'class' => 'col-5',
                    'placeholder' => 'From...',
                    'disabled' => 'disabled'
                ]); !!}

                <!--- targetCurrency select Field --->
                    {!! Form::select('to', [], null, [
                        'id' => 'selectTargetCurrency',
                        'class' => 'col-5',
                        'placeholder' => 'To...',
                        'disabled' => 'disabled'
                    ]); !!}
                </div>
            </div>

            <!--- submit Field --->
            <div class="form-group">
                {!! Form::button('Convert', [
                    'id' => 'btnConvert',
                    'class' => 'btn btn-primary col-12',
                    'disabled' => 'disabled'
                ]) !!}
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>