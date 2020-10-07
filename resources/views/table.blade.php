<table class="table">
    <tr>
        <th>{{__('app.Title')}}</th>
        <th>{{__('app.Priority')}}</th>
        <th>{{__('app.End date')}}</th>
        <th>{{__('app.Assigned user')}}</th>
        <th>{{__('app.Status')}}</th>
    </tr>
    @foreach($tasks as $task)
        <tr data-id="{{$task->id}}" class="taskRow">
            <td style="color: {{$task->taskColor()}}">{{$task->title}}</td>
            <td>{{__('app.'.$task->getPriorityName())}}</td>
            <td>{{$task->end_date}}</td>
            <td>{{$task->userName()}}</td>
            <td>{{__('app.'.$task->getStatusName())}}</td>
        </tr>
    @endforeach
</table>
