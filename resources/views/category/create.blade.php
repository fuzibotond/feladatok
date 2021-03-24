@extends('home')

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
                   
                    <form method="post" action="{{ url('categories') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="tulajdonos" class="form-control" 
                            placeholder="Enter Owner Name" />
                        </div>
                        <div class="form-group">
                            <label for="exampleFromControlSelect1">Válassz autót!</label>
                            <select class="from-control"  id="exampleFromControlSelect1" name="auto">
                                @foreach ($autos as $auto)
                                <option value="{{$auto->id}}" >{{ $auto->megnevezes }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input 
                                    id="active" 
                                    name="garancialis" 
                                    type="checkbox" 
                                    class="form-check-input"
                                    for="active"
                                    checked
                                 
                                >Garancia
                            </div>    
                        </div>
                        <div class="form-group" action="")>
                            <label>
                                Autó életkora:
                            </label><br>
                            @foreach($auto_eletkors as $age)
                                <input type="radio" id="eletkor" name="eletkor" value="{{!! $age->id !!}}">{{ $age->megnevezes }}
                            @endforeach
                        </div>
                        
                        <div class="form-group">A szervíz kezdete:
                            <input type="datetime-local" name="szerviz_kezdete" value="<?php echo date("Y-m-d\TH:i:s",time()); ?>" step="any"/>
                        </div>
                        {{-- <div class="form-group">
                            <input type="datetime-local" name="szerviz_vege" value="<?php echo date("Y-m-d\TH:i:s",time()); ?>" step="any"/>
                        </div> --}}
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
