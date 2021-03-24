@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-felx align-items-center justify-content-between">
                    <div class="inline-block">
                        <h1>Szerizkönyvek</h1>
                    </div>
                    
                </div>
                <div>
                    <a class="btn btn-warning" href="{{ route('home') }}">Back</a>
                </div>
                <div class="card-body d-flex align-items-center">
                    <table border="1"  style="width:100%" >
                        <tr>
                            <td><h5>Tulajdonos</h1></td>
                            <td><h5>Auto</h1></td>
                            <td><h5>Garancia</h1></td>
                            <td><h5>Életkor</h1></td>
                            <td><h5>Szervízkönyv kezdete</h1></td>
                            <td><h5>Szervízkönyv vege</h1></td>
                            <td><h5>Törlés</h1></td>
                        </tr>
                        <tr>
                        @foreach ($categories as $category)
                            <td>{{ $category['tulajdonos'] }}</td>
                            <td>
                                @foreach ($autos as $auto)
                                    @if ($auto['id']==$category['auto'])
                                        {{ $auto['megnevezes'] }}
                                    @endif
                                @endforeach 
                               </td>
                            <td>
                                @if ($category['garancialis']==1)
                                    {{ 'Igen' }}
                                @else
                                    {{ 'Nem' }}
                                @endif
                            </td>
                            <td>@foreach ($auto_eletkors as $age)
                                @if ($age['id']==$category['auto'])
                                    {{ $age['megnevezes'] }}
                                @endif
                            @endforeach </td>
                            <td>{{ $category['szerviz_kezdete'] }}</td>
                            <td>{{ $category['szerviz_vege'] }}</td>
                            <td><a href={{ $category['id'] }}>Törlés</a></td>
                        </tr>   
                        @endforeach
                    </table>
                    
                </div>
               
            </div>
            
        </div>
        
    </div>
</div>
@endsection
