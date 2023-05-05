@extends('layouts.app')
@section('css')

        <link href= "{{ asset('vendor/sb-admin-2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>

@endsection

@section('content')

            <div class="content container">

                <form action="" method="get" style="max-width:600px;padding:20px;">
                    @csrf
                    <div class="form-row align-items-center">
                        <div class="form-group col-md-7">
                        <label for="month">Input a month</label>
                        <input type="month" name="month" id="month" class="form-control">
                        <small>example: January 2019</small>
                            @error('month')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn form-control btn-primary mb-2 footer-button">Get Data</button>
                        </div>
                    </div>
                </form>
                
                <div class="card-body">
                    @isset($collections)
                        <div class="d-flex align-items-center p-4">
                            <h3 class="mr-auto"> {{ session('month') }}</h3>
                            <div>
                                {{-- <a href="{{route('home')}}" class="btn btn-secondary btn-icon-split">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-arrow-left"></i>
                                    </span>
                                    <span class="text">Select another month</span>
                                </a> --}}
                                <a href="{{ route('export.excel') }}" class="btn btn-success">Export to Excel</a>
                            </div>
                        </div>
                        @php $counter = 0; @endphp
                    
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th>Retailer</th>
                                <th>City</th>
                                <th>Brands</th>
                                <th>Model</th>
                                <th>Brand + Model</th>
                                <th>Sales Units</th>
                                <th>Unit price</th>
                                <th>Sales Value</th>
                            </tr>
                            @forelse ($collections as $collection)
                            @php $counter++; @endphp
                                <tr>
                                    <td>{{ $collection['Retailer'] ?? ' ' }}</td>
                                    <td>{{ $collection['City'] ?? ' ' }}</td>
                                    <td>{{ $collection['A_Brands'] ?? ' ' }}</td>
                                    <td>{{ $collection['C_Model'] ?? '' }}</td>
                                    <td> {{ $collection['A_Brands'] ?? ' ' }} {{ $collection['C_Model'] ?? '' }}</td>
                                    <td>{{ $collection['F_Sales units'] ?? '' }}</td>
                                    <td>{{ $collection['G_Unit price'] ?? '' }}</td>
                                    <td>
                                        {{ number_format(($collection['F_Sales units'] ?? 0) * ($collection['G_Unit price'] ?? 0)) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>No available data.</tr>
                            @endforelse

                        </table>
                        <p>{{ $counter }}</p>
                    @endisset
                    @empty($collections)
                        <div>No records yet.</div>
                    @endempty
                </div>
            </div>
         <!-- Scroll to Top Button-->
        {{-- <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a> --}}

        

@endsection

@section('js')
        <script src="{{ asset('vendor/sb-admin-2.min.js') }}"></script>
@endsection
