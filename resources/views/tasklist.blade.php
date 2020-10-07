@extends('layouts.app')

@section('pagespecificscripts')
    <script type="text/javascript" src="{{ asset('js/tasklist.js') }}" defer></script>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                {{__('app.Mode')}}
                <form method="get">
                    <br>
                    <input type="radio" name="mode" @if(request()->get('mode') == 'date') checked @endif value="date"> {{__('app.Sort by date')}}
                    @if(Auth::user()->hasAssigned())
                    <br>
                    <input type="radio" name="mode" @if(request()->get('mode') == 'assigned') checked @endif value="assigned"> {{__('app.Sort by assigned users')}}
                    @endif
                    <br>
                    <input type="radio" name="mode" @if(request()->get('mode') == 'all' || request()->get('mode') == null) checked @endif value="all"> {{__('app.Get all')}}
                    <br>
                    <button class="btn btn-dark" type="submit">Применить</button>
                </form>
            </div>
            <div class="col-md bg-white border-dark border p-2">
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taskModal">
                        {{__('app.Add new task')}}
                    </button>
                </p>
                @if(request()->get('mode') == 'date' || request()->get('mode') == 'assigned')
                    @foreach($tasks as $type => $tasksByType)
                        @if(request()->get('mode') == 'assigned')
                            <h5>{{__($type)}}</h5>
                        @else
                        <h5>{{__('app.'.$type)}}</h5>
                        @endif
                        @include('table', ['tasks' => $tasksByType])
                    @endforeach
                @endif
                @if(request()->get('mode') == 'all' || request()->get('mode') == null)
                        @include('table', ['tasks' => $tasks])
                @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="taskModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('app.Task')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="sendForm">
                    @csrf
                        <input type="text" name="id" hidden>
                    <div class="row mb-1">
                        <div class="col">
                            {{__('app.Title')}}
                        </div>
                        <div class="col">
                            <input name="title" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            {{__('app.Description')}}
                        </div>
                        <div class="col">
                            <input name="description" type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            {{__('app.End date')}}
                        </div>
                        <div class="col">
                            <input name="end_date" type="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            {{__('app.Priority')}}
                        </div>
                        <div class="col">
                            <select name="priority" class="form-control">
                                @foreach($priorities as $priority)
                                    <option value="{{$priority->id}}">{{__('app.'.$priority->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            {{__('app.Status')}}
                        </div>
                        <div class="col">
                            <select name="status" class="form-control">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{__('app.'.$status->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            {{__('app.Assigned user')}}
                        </div>
                        <div class="col">
                            <select name="assigned_user_id" id="leader_id" class="form-control">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} {{$user->surname}} {{$user->middle_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeForm" class="btn btn-secondary" data-dismiss="modal">{{__('app.Close')}}</button>
                    <button type="submit" id="save" class="btn btn-primary">{{__('app.Save changes')}}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
