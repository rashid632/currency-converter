@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container my-2">
                        <div class="row">
                            <div class="col-12">
                                <passport-clients></passport-clients>
                            </div>
                        </div>
                    </div>
                    <div class="container my-2">
                        <div class="row">
                            <div class="col-12">
                                <passport-authorized-clients></passport-authorized-clients>
                            </div>
                        </div>
                    </div>

                    <div class="container my-2">
                        <div class="row">
                            <div class="col-12">
                                <passport-personal-access-tokens></passport-personal-access-tokens>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
