@extends('layouts.main')
@section('pagename', 'Авторизация')
@section('title', 'Авторизация')

@section('content')
    @if($users->count())
        <div class='row justify-content-center'>
            <div class='col-12 text-center'>
                <h4>Войти как пользователь</h4>
            </div>
        </div>
        <div class='row justify-content-center'>
            @foreach($users as $user)
            <div class='col-auto'>
                <div class="card mt-3 op-eff op-null" style="width: 12rem;">
                    <div class="mt-3 img user-img {{$user->printIcon()}}"></div>
                    <div class="card-body">
                        <h5 class="card-title">{!!$user->printName()!!}</h5>
                        <p class="card-text">Должность {{$user->printRoles()}}</p>
                        <button id='{{$user->id}}' class="btn btn-primary clickable">Войти</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        Нет пользователей
    @endif    
@endsection