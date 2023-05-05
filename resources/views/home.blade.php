@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div style="width:60%;margin:auto">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('data.send') }}" method="get">
                            @csrf
                            <div class="form-group">
                                <div class="form-group">
                                <label for="month">Input a month</label>
                                <input type="month" name="month" id="month" class="form-control">
                                <small>example: January 2019</small>
                                @error('month')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                            </div>
                            <button type="submit" class="btn form-control btn-primary mb-2 footer-button">Get Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
