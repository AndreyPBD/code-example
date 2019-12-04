<div class="table-responsive">
    <table class="table" id="workouts-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Training Type</th>
            <th>Duration</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($workouts as $workout)
            <tr>
                <td>{!! $workout->name !!}</td>
                <td>{!! $workout->author->name !!}</td>
                <td>{!! $workout->trainingType->name !!}</td>
                <td>{!! $workout->duration !!}</td>
                <td>
                    {!! Form::open(['route' => ['workouts.destroy', $workout->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('workouts.show', [$workout->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('workouts.edit', [$workout->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
