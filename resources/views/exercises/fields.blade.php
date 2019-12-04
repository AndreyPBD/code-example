<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Muscle Groups -->
<div class="form-group col-sm-6">
    {!! Form::label('muscle_group', 'Muscle Group:') !!}

    <select name="muscle_groups[]" id="muscle_groups[]" class="select2-multiple" multiple>
        @foreach($muscleGroups as $key => $value)
            <option value="{{ $key }}"
            @if($exercise->muscleGroups->containsStrict('name', $value))
                {{ 'selected' }}
                @endif
            >{{ $value }}
            </option>
        @endforeach
    </select>
</div>

<!-- Additional Muscle Groups -->
<div class="form-group col-sm-6">
    {!! Form::label('additional_muscle_group', 'Additional Muscle Group:') !!}

    <select name="additional_muscle_groups[]" id="muscle_groups[]" class="select2-limited-tags-number" multiple>
        @foreach($muscleGroups as $key => $value)
            <option value="{{ $key }}"
            @if($exercise->additionalMuscleGroups->containsStrict('name', $value))
                {{ 'selected' }}
                @endif
            >{{ $value }}
            </option>
        @endforeach
    </select>
</div>

<!-- Muscle -->
<div class="form-group col-sm-6">
{{--    {!! Form::label('muscle', 'Muscle:') !!}--}}

{{--    <select name="muscle" id="muscle" class="select2-single">--}}
{{--        @foreach($muscles as $key => $value)--}}
{{--            <option value="{{ $key }}"--}}
{{--                @if($exercise->muscle->get('name') === $value)--}}
{{--                    {{ 'selected' }}--}}
{{--                @endif--}}
{{--                >{{ $value }}--}}
{{--            </option>--}}
{{--        @endforeach--}}
{{--    </select>--}}

    {!! Form::label('muscle_id', 'Muscle:') !!}
    {!! Form::select('muscle_id', $muscles, null, ['class' => 'select2-single']) !!}
</div>

<!-- Difficulty Level Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('difficulty_level_id', 'Difficulty Level:') !!}
    {!! Form::select('difficulty_level_id', $difficultyLevels, null, ['class' => 'select2-single']) !!}
</div>

<!-- Training Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('training_type_id', 'Training Type:') !!}
    {!! Form::select('training_type_id', $trainingTypes, null, ['class' => 'select2-single']) !!}
</div>

<!-- Positive Phase Duration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('positive_phase_duration', 'Positive Phase Duration:') !!}
    {!! Form::number('positive_phase_duration', $exercise->positive_phase['duration'] ?? '', ['min' => '0', 'class' => 'form-control']) !!}
</div>

<!-- Positive Phase Breath Field -->
<div class="form-group col-sm-6">
    {!! Form::label('positive_phase_breath', 'Positive Phase Breath:') !!}
    {!! Form::select('positive_phase_breath', [\App\Models\Exercise::BREATH_IN => 'Inhale', \App\Models\Exercise::BREATH_OUT => 'Exhale'], null, ['class' => 'form-control']) !!}
</div>

<!-- Negative Phase Duration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('negative_phase_duration', 'Negative Phase Duration:') !!}
    {!! Form::number('negative_phase_duration', $exercise->negative_phase['duration'] ?? '', ['min' => '0', 'class' => 'form-control']) !!}
</div>

<!-- Negative Phase Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('negative_phase_breath', 'Negative Phase Breath:') !!}
    {!! Form::select('negative_phase_breath', [\App\Models\Exercise::BREATH_IN => 'Inhale', \App\Models\Exercise::BREATH_OUT => 'Exhale'], null, ['class' => 'form-control']) !!}
</div>

<!-- Exercise Biomechanics Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exercise_biomechanics_id', 'Exercise Biomechanics:') !!}
    {!! Form::select('exercise_biomechanics_id', $exerciseBiomechanics, null, ['class' => 'select2-single']) !!}
</div>

<!-- Exercise Force Vector Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exercise_force_vector_id', 'Exercise Force Vector:') !!}
    {!! Form::select('exercise_force_vector_id', $exerciseForceVector, null, ['class' => 'select2-single']) !!}
</div>

<!-- Replacement Exercises Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('replacement_exercises', 'Replacement Exercises:') !!}

    <select name="replacement_exercises[]" id="replacement_exercises[]" class="select2-multiple" multiple>
        @foreach($replacementExercises as $key => $value)
            <option value="{{ $key }}"
                @if($exercise->replacementExercises->containsStrict('name', $value))
                    {{ 'selected' }}
                @endif
                >{{ $value }}
            </option>
        @endforeach
    </select>

</div>

<!-- Equipment Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('equipments', 'Equipments:') !!}

    <select name="equipments[]" id="equipments[]" class="select2-multiple" multiple>
        @foreach($equipments as $key => $value)
            <option value="{{ $key }}"
                @if($exercise->equipments->containsStrict('name', $value))
                    {{ 'selected' }}
                @endif
                >{{ $value }}
            </option>
        @endforeach
    </select>

</div>

<!-- Is Side Changing Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_side_changing', 'Side Changing:') !!}
    {!! Form::select('is_side_changing', [0 => 'No', 1 => 'Yes'], null) !!}
</div>

<!-- Technique Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('technique', 'Technique:') !!}
    {!! Form::textarea('technique', null, ['class' => 'form-control']) !!}
</div>

<!-- Warning Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('warning', 'Warning:') !!}
    {!! Form::textarea('warning', null, ['class' => 'form-control']) !!}
</div>

<!-- Short Advice Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('short_advice', 'Short Advice:') !!}
    {!! Form::textarea('short_advice', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image_id', 'Images:') !!}
    {!! Form::file('images[]', ['multiple' => 'multiple', 'class' => 'form-control', 'accept'=>'image/*']) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    {!! Form::select('is_active', [0 => 'No', 1 => 'Yes'], null) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('exercises.index') !!}" class="btn btn-default">Cancel</a>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".select2-limited-tags-number").select2({
                maximumSelectionLength: 5
            });
        });
    </script>
@endsection
