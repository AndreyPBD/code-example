@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Exercise
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($exercise, ['route' => ['exercises.update', $exercise->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                    @include('exercises.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
