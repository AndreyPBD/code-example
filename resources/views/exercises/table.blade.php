<div class="table-responsive">
    <table class="table" id="exercises-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Difficulty Level</th>
            <th>Training Type</th>
            <th>Active</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($exercises as $exercise)
            <tr>
                <td>{!! $exercise->name !!}</td>
                <td>{!! $exercise->author->name !!}</td>
                <td>{!! $exercise->difficultyLevel->name !!}</td>
                <td>{!! $exercise->trainingType->name !!}</td>
                <td>
                    @if ($exercise->is_active == 1)
                        <i class="glyphicon glyphicon-ok"></i>
                    @else
                        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['exercises.destroy', $exercise->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('exercises.show', [$exercise->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('exercises.edit', [$exercise->id]) !!}" class='btn btn-default btn-xs'><i
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
