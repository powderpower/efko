@extends('layouts.main')
@section('pagename', 'Управление')
@section('title', 'Управление | ' . $user->printName())
@section('extra-btn')
    <button class='btn btn-danger float-right clickable' opt='logout'>Выйти</button>
@endsection

@section('content')
    <div class='row justify-content-center'>
        <div class='col-lg-3 col-md-3 col-sm-6 col-6 @if(!$isMain) offset-lg-3 offset-md-2 offset-md-2 @endif'>
            <div class="card @if($isMain) c-alone @endif" style="width: 12rem;">
                <div class="mt-3 img user-img {{$user->printIcon()}}"></div>
                <div class="card-body">
                    <h5 class="card-title">{{$user->printName()}}</h5>
                    <p class="card-text">Должность<br>{{$user->printRoles()}}</p>
                </div>
            </div>            
        </div>
        @if($user->hasRole('Менеджер'))
            <div class='col-lg-6 col-md-6 col-sm-9'>
                <div class="form-group row mt-4">
                    <div class="col-lg-6 offset-lg-1 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-6 offset-3">
                        @if(empty($user->vacation) || (!empty($user->vacation) && !$user->vacation->accepted))
                            <span class="font-weight-bold">Дата ухода в отпуск</span><br>
                            <input class="form-control mt-2 mb-2" id='ask-vacation-leave' type="date" min='{{$minDateLeave}}' value="{{$minDateLeave}}">
                            <span class="font-weight-bold">Дата возвращения</span><br>
                            <input class="form-control mt-2" id='ask-vacation-back' type="date" min='{{$minDateBack}}' value="{{$minDateBack}}">
                            <button class='btn btn-success clickable mt-2' opt='ask-vacation'>Запросить</button>
                        @endif
                        @if(!empty($user->vacation))
                            <div class="font-weight-bold mt-3 mb-2">Вы запрашивали отпуск на даты</div>
                            {{$user->vacation->printLeave()}}
                            <div>Статус: {{$user->vacation->status}}</div>
                        @endif                    
                    </div>
                </div>
            </div>
        @endif
    </div>
        @if($vacations->count())
            <div class='row justify-content-center'>
                <div class='col-md-12 text-center mt-2 font-weight-bold'>Запросы отпусков</div>
            </div>    

            <table class="table mt-2 text-center table-hover table-bordered @if($isMain) sm-add-h @endif">
                <thead>
                    <tr>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Статус</th>
                    @if($isMain)
                        <th scope="col">Действие</th>
                    @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($vacations as $vacation)
                        <tr>
                            <td class="align-middle">{{$vacation->user->printName()}}</td>
                            <td class="align-middle">{{$vacation->printLeave()}}</td>
                            <td class="align-middle sm-hide">{{$vacation->status}}</td>  
                            @if($isMain)
                                <td class="align-middle">
                                    @if(!$vacation->accepted)
                                    <div class="btn-group-vertical">    
                                        <button class='btn btn-success clickable btn-sm btn-st' id='{{$vacation->user->id}}' opt='accept'>Согласовать</button>
                                        <button class='btn btn-danger clickable btn-sm btn-st mt-2' id='{{$vacation->user->id}}' opt='refuse'>Отказать</button>
                                    </div>
                                    @else
                                        Заявка обработана
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($isMain)
                <div class='row justify-content-center'>
                    <div class='col-12 mt-2 text-center'>
                        <button class='btn btn-danger clickable' opt='clear'>Отчистить список</button>
                    </div>
                </div>
            @endif
        @else
            <div class='row justify-content-center'>
                <div class='col-md-12 text-center mt-2 font-weight-bold'>Пользователи не оставляли заявок</div>
            </div>        
        @endif
    </div>
@endsection