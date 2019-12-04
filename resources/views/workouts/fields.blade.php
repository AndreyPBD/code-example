
<div class="flex">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Author Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('author_id', 'Author:') !!}
        {!! Form::select('author_id', $users, null, ['class' => 'select2-single']) !!}
    </div>

    <!-- Duration Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('duration', 'Duration:') !!}
        {!! Form::number('duration', null, ['min' => 0, 'class' => 'form-control']) !!}
    </div>

    <!-- Training Type Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('training_type_id', 'Training Type:') !!}
        {!! Form::select('training_type_id', $trainingTypes, null, ['class' => 'select2-single']) !!}
    </div>
</div>




<!-- Exercises Field -->
<div class="exercises">
    <div class="exercise">
        <div class="col-sm-12">
            <div class="form-group col-sm-4 exercise_left">
                {!! Form::label('exercises', 'Exercises:') !!}
                {!! Form::select('exerciseId', $exercises, null, ['class' => 'select2-single']) !!}
            </div>
            <div class="col-sm-8 exercise_right-wr">
                <div class="exercise_right">
                    <label class="workout-exercise-label">
                        <p>Sets</p>
                        <input name="sets" class="workout-exercise-input" type="text">
                    </label>
                    <label class="workout-exercise-label">
                        <p>Reps</p>
                        <input name="reps" class="workout-exercise-input" type="text">
                    </label>
                    <label class="workout-exercise-label"> <p> Break Time </p>
                        <input name="break_time" class="workout-exercise-input" type="text">
                    </label>
                    <label class="workout-exercise-label"> <p>Weight</p>
                        <input name="weight" class="workout-exercise-input" type="text">
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-12 plus-wr">
    <h3 class="plus">+</h3>
</div>



<input class="exercisesInfo" type="text" name="ExercisesInfo" >

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <div><span class="update-exercises btn btn-primary">save exercises</span></div>
    {!! Form::submit('Save', ['class' => 'btn btn-primary save-workout']) !!}
    <a href="{!! route('workouts.index') !!}" class="btn btn-default">Cancel</a>
</div>

@section('scripts')

    <script>
        $(document).ready(function() {
            $(".save-workout").prop('disabled', true);
            var row = '<div class="exercise">' +
                            '<div class="col-sm-12">' +
                                '<div class="form-group col-sm-4 exercise_left">' +
                                    '<label for="exercises">Exercises:</label>' +
                                    '<select name="exerciseId" class="new_select"></select>' +
                                '</div>' +
                                '<div class="col-sm-8 exercise_right-wr">' +
                                        '<div class="exercise_right">' +
                                        '<label class="workout-exercise-label">' +
                                            '<p>Sets</p>' +
                                            '<input name="sets" class="workout-exercise-input" type="text">' +
                                        '</label>' +
                                        '<label class="workout-exercise-label">' +
                                            '<p>Reps</p>' +
                                            '<input name="reps" class="workout-exercise-input" type="text">' +
                                        '</label>' +
                                        '<label class="workout-exercise-label">' +
                                            '<p> Break Time </p>' +
                                            '<input name="break_time" class="workout-exercise-input" type="text">' +
                                        '</label>' +
                                        '<label class="workout-exercise-label">' +
                                            '<p>Weight</p>' +
                                            '<input name="weight" class="workout-exercise-input" type="text">' +
                                        '</label>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            var exercises = $(".exercises");
            var select = $('.exercise .select2-single').html();
            var exercisesInfo = [];

            function addRow(){
                let newRow = row;
                exercises.append(newRow);
                $('.new_select').append(select);
                $('.new_select').select2();
            }

            function createArr(){
                var rowInputs = $(exercises).find(':input');
                var exerciseArr = {};
                for(var i=0; i<rowInputs.length; i++){
                        var newName = rowInputs[i].name;
                        var newValue = rowInputs[i].value;
                        exerciseArr[newName] = newValue;
                    if ((i+1)%5 === 0){
                        exercisesInfo.push(Object.assign({}, exerciseArr));
                        exerciseArr = {};
                    }
                }
                // exercisesInfo = exerciseArr.map(el=> exerciseArr.splice(0,5)).filter(el=>el);
                var myJsonString = JSON.stringify(exercisesInfo);
                $('.exercisesInfo').val(myJsonString);
                $(".save-workout").prop('disabled', false);
            }
            $(document).on('click', '.plus', addRow);
            $(document).on('click', '.update-exercises', createArr);
        });
    </script>

@endsection
