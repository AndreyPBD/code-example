<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! $workout->name !!}
</div>

<!-- Author Id Field -->
<div class="form-group">
    {!! Form::label('author_id', 'Author:') !!}
    <a href="{{ route('users.show', $workout->author->id) }}">{!! $workout->author->name !!}</a>
</div>

<!-- Training Type Id Field -->
<div class="form-group">
    {!! Form::label('training_type_id', 'Training Type:') !!}
    <a href="{{ route('trainingTypes.show', $workout->trainingType->id) }}">{!! $workout->trainingType->name !!}</a>
</div>

<!-- Duration Field -->
<div class="form-group">
    {!! Form::label('duration', 'Duration:') !!}
    {!! $workout->duration !!}
</div>

<!-- Exercises Field -->
<div class="form-group">
    {!! Form::label('exercises', 'Exercises:') !!}
    @if(!empty($workout->exercises))

        @foreach($workout->exercises->pluck('name', 'id') as $key => $value)
            <div>
                <a href="{{ route('exercises.show', $key) }}">{!! $value !!}</a>
            </div>
        @endforeach

    @endif
</div>

