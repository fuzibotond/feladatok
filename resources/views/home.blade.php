@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-contenet-between">
                        <div class="inline-block">
                            <h1>Dashboard</h1> 
                        </div>
                        <div class="inline-block">
                            <form class="inline-block align-item-right" style="margin:50px" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                </div>
                
                <div class="card-body">
                    
                    You are logged in!
                    <div class="d-flex align-items-between">
                        <a class="btn btn-success x-50 m-1" href="http://127.0.0.1:8000/autos/create">Auto Hozzáadsa</a>
                        
                    </div>
                    <div class="d-flex align-items-between">
                        <a class="btn btn-success x-50 m-1" href="http://127.0.0.1:8000/categories/create">Szervizkonyv Hozzáad</a>
                        <a class="btn btn-success x-50 m-1" href="http://127.0.0.1:8000/categories/">Szervizkonyv Listázása</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
