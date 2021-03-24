@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-felx align-items-center justify-content-between">
                    <div class="inline-block">
                        {{('Hozzáad') }}
                    </div>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{\Session::get('success') }}</p>
                    </div>    
                    @endif
                <div class="card-body">
                   
                    <form method="post" action="{{ url('autos') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="megnevezes" class="form-control" 
                            placeholder="Name it" />
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary"/>
                            <a class="btn btn-warning" href="{{ route('home') }}">Back</a>
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
