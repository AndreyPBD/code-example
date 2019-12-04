<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! $exercise->name !!}
</div>

<!-- Author Id Field -->
<div class="form-group">
    {!! Form::label('author_id', 'Author:') !!}
    <a href="{{ route('users.show', $exercise->author->id) }}">{!! $exercise->author->name !!}</a>
</div>

<!-- Difficulty Level Id Field -->
<div class="form-group">
    {!! Form::label('difficulty_level_id', 'Difficulty Level:') !!}
    <a href="{{ route('difficultyLevels.show', $exercise->difficultyLevel->id) }}">{!! $exercise->difficultyLevel->name !!}</a>
</div>

<!-- Training Type Id Field -->
<div class="form-group">
    {!! Form::label('training_type_id', 'Training Type:') !!}
    <a href="{{ route('trainingTypes.show', $exercise->trainingType->id) }}">{!! $exercise->trainingType->name !!}</a>
</div>

<div class="form-group">
    @if(!empty($exercise->muscle))
        {!! Form::label('muscles_id', 'Muscle:') !!}
        <a href="{{ route('muscles.show', $exercise->muscle->id) }}">{!! $exercise->muscle->name !!}</a>
    @endif
</div>

<div class="form-group">
    {!! Form::label('muscleGroups', 'Muscle Groups:') !!}
    @if(!empty($exercise->muscleGroups))
        @foreach($exercise->muscleGroups->pluck('name', 'id')->toArray() as $key => $value)
            <div>
                <a href="{{ route('muscleGroups.show', $key) }}">{!! $value !!}</a>
            </div>
        @endforeach
    @endif
</div>

<div class="form-group">
    {!! Form::label('additionalMuscleGroups', 'Additional Muscle Groups:') !!}
    @if(!empty($exercise->additionalMuscleGroups))
        @foreach($exercise->additionalMuscleGroups->pluck('name', 'id')->toArray() as $key => $value)
            <div>
                <a href="{{ route('muscleGroups.show', $key) }}">{!! $value !!}</a>
            </div>
        @endforeach
    @endif
</div>

<div class="form-group">
    {!! Form::label('Replacement Exercises', 'Replacement Exercises:') !!}
    @if(!empty($exercise->replacementExercises))
        @foreach($exercise->replacementExercises->pluck('name', 'id')->toArray() as $key => $value)
            <div>
                <a href="{{ route('exercises.show', $key) }}">{!! $value !!}</a>
            </div>
        @endforeach
    @endif
</div>

<div class="form-group">
    {!! Form::label('equipments', 'Equipments:') !!}
    @if(!empty($exercise->equipments))
        @foreach($exercise->equipments->pluck('name', 'id')->toArray() as $key => $value)
            <div>
                <a href="{{ route('equipment.show', $key) }}">{!! $value !!}</a>
            </div>
        @endforeach
    @endif
</div>


<!-- Is Active Field -->
<div class="form-group">
    {!! Form::label('is_active', 'Active:') !!}
    @if ($exercise->is_active == 1)
        <i class="glyphicon glyphicon-ok"></i>
    @else
        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
    @endif
</div>

<!-- Positive Phase Duration Field -->
<div class="form-group">
    {!! Form::label('positive_phase', 'Positive Phase Duration:') !!}
    {!! $exercise->positive_phase['duration'] !!}
</div>

<!-- Positive Phase Breath Field -->
<div class="form-group">
    {!! Form::label('positive_phase', 'Positive Phase Breath:') !!}
    {!! $exercise->positive_phase['breath'] !!}
</div>

<!-- Negative Phase Duration Field -->
<div class="form-group">
    {!! Form::label('negative_phase', 'Negative Phase Duration:') !!}
    {!! $exercise->negative_phase['duration'] !!}
</div>

<!-- Negative Phase Breath Field -->
<div class="form-group">
    {!! Form::label('negative_phase', 'Negative Phase Breath:') !!}
    {!! $exercise->negative_phase['breath'] !!}
</div>

<!-- Breath Field -->
<div class="form-group">
    {!! Form::label('breath', 'Breath:') !!}
    {!! $exercise->breath !!}
</div>

<!-- Exercise Biomechanics Id Field -->
<div class="form-group">
    {!! Form::label('exercise_biomechanics_id', 'Exercise Biomechanics:') !!}
    <a href="{{ route('exerciseBiomechanics.show', $exercise->exerciseBiomechanics->id) }}">{!! $exercise->exerciseBiomechanics->name !!}</a>
</div>

<!-- Exercise Force Vector Id Field -->
<div class="form-group">
    {!! Form::label('exercise_force_vector_id', 'Exercise Force Vector:') !!}
    <a href="{{ route('exerciseForceVectors.show', $exercise->exerciseForceVector->id) }}">{!! $exercise->exerciseForceVector->name !!}</a>
</div>

<!-- Is Side Changing Field -->
<div class="form-group">
    {!! Form::label('is_side_changing', 'Side Changing:') !!}
    @if ($exercise->is_side_changing == 1)
        <i class="glyphicon glyphicon-ok"></i>
    @else
        <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
    @endif
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', 'Images:', ['class' => 'text-left']) !!}
</div>
<div class="col-sm-12">
    <div class="col-sm-6 col-sm-offset-3">
        @if ($exercise->images->isNotEmpty())
            <div class="carousel-inner owl-theme">
                <div class="owl-carousel owl-theme">
                    @foreach ($exercise->images as $image)
                        <img class="img-responsive" src="{{( Storage::url($image->path)) }}" alt="{!! $exercise->name !!}" width="200" height="200">
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Technique Field -->
<div class="form-group">
    {!! Form::label('technique', 'Technique:') !!}
    <p>{!! $exercise->technique !!}</p>
</div>

<!-- Warning Field -->
<div class="form-group">
    {!! Form::label('warning', 'Warning:') !!}
    <p>{!! $exercise->warning !!}</p>
</div>

<!-- Short Advice Field -->
<div class="form-group">
    {!! Form::label('short_advice', 'Short Advice:') !!}
    <p>{!! $exercise->short_advice !!}</p>
</div>

@section('scripts')
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            items: 1,
            autoHeight: true,
            nav: true,
            dots: true,
            dotsEach: true,
            navText: [
                '<i class="glyphicon glyphicon-arrow-left"></i>',
                '<i class="glyphicon glyphicon-arrow-right"></i>'
            ]
        })
    </script>
@endsection
