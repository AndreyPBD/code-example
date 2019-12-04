<?php

namespace App\Models;

use Eloquent as Model;

/**
 * // toDo: set only fillable fields "ExerciseSet" block. And all other in ExerciseGet block.
 *
 * @SWG\Definition (
 *      definition="ExerciseSet",
 *      type="object",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="author_id",
 *          description="author_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="difficulty_level_id",
 *          description="difficulty_level_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="training_type_id",
 *          description="training_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_active",
 *          description="is_active",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="positive_phase_duration",
 *          description="positive_phase_duration",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="positive_phase_breath",
 *          description="positive_phase_breath",
 *          type="string",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="negative_phase_duration",
 *          description="negative_phase_duration",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="negative_phase_breath",
 *          description="negative_phase_breath",
 *          type="string",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="exercise_biomechanics_id",
 *          description="exercise_biomechanics_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="exercise_force_vector_id",
 *          description="exercise_force_vector_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_side_changing",
 *          description="is_side_changing",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="technique",
 *          description="technique",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="warning",
 *          description="warning",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="short_advice",
 *          description="short_advice",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * ),
 * @SWG\Definition (
 *  definition="ExerciseGet",
 *  allOf={
 *    @SWG\Schema(ref="#/definitions/ExerciseSet"),
 *    @SWG\Schema(
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="author_id",
 *          description="author_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="difficulty_level_id",
 *          description="difficulty_level_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="training_type_id",
 *          description="training_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_active",
 *          description="is_active",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="positive_phase_time",
 *          description="positive_phase_time",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="negative_phase_time",
 *          description="negative_phase_time",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="breath",
 *          description="breath",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="exercise_biomechanics_id",
 *          description="exercise_biomechanics_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="exercise_force_vector_id",
 *          description="exercise_force_vector_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_side_changing",
 *          description="is_side_changing",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="technique",
 *          description="technique",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="warning",
 *          description="warning",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="short_advice",
 *          description="short_advice",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 *    ),
 *  }
 * ),
 * @property int $id
 * @property string $name
 * @property int $author_id
 * @property int $difficulty_level_id
 * @property int $training_type_id
 * @property bool $is_active
 * @property int|null $positive_phase_time
 * @property int|null $negative_phase_time
 * @property string|null $breath
 * @property int $exercise_biomechanics_id
 * @property int $exercise_force_vector_id
 * @property bool|null $is_side_changing
 * @property string|null $technique
 * @property string|null $warning
 * @property string|null $short_advice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\DifficultyLevel $difficultyLevel
 * @property-read \App\Models\ExerciseBiomechanics $exerciseBiomechanics
 * @property-read \App\Models\ExerciseForceVector $exerciseForceVector
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Muscle[] $muscles
 * @property-read int|null $muscles_count
 * @property-read \App\Models\TrainingType $trainingType
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereBreath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereDifficultyLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereExerciseBiomechanicsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereExerciseForceVectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereIsSideChanging($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereNegativePhaseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise wherePositivePhaseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereShortAdvice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereTechnique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereTrainingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereWarning($value)
 * @mixin \Eloquent
 */

class Exercise extends Model
{

    public $table = 'exercises';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public const FILE_DIR = 'img/exercises/';
    public const BREATH_IN = 'inhale';
    public const BREATH_OUT = 'exhale';



    public $fillable = [
        'name',
        'author_id',
        'difficulty_level_id',
        'training_type_id',
        'is_active',
        'muscle_id',
        'positive_phase',
        'negative_phase',
        'exercise_biomechanics_id',
        'exercise_force_vector_id',
        'is_side_changing',
        'technique',
        'warning',
        'short_advice',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'author_id' => 'integer',
        'difficulty_level_id' => 'integer',
        'training_type_id' => 'integer',
        'is_active' => 'boolean',
        'muscle_id' => 'integer',
        'positive_phase' => 'array',
        'negative_phase' => 'array',
        'exercise_biomechanics_id' => 'integer',
        'exercise_force_vector_id' => 'integer',
        'is_side_changing' => 'boolean',
        'technique' => 'string',
        'warning' => 'string',
        'short_advice' => 'string',
    ];

    /**
     * Validation rules for create Model
     *
     * @var array
     */
    public static $create_rules = [
        'name' => 'required',
        'difficulty_level_id' => 'required',
        'training_type_id' => 'required',
        'is_active' => 'required',
        'exercise_biomechanics_id' => 'required',
        'exercise_force_vector_id' => 'required'
    ];

    /**
     * Validation rules for update Model
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required',
        'difficulty_level_id' => 'required',
        'training_type_id' => 'required',
        'is_active' => 'required',
        'exercise_biomechanics_id' => 'required',
        'exercise_force_vector_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function difficultyLevel()
    {
        return $this->belongsTo(DifficultyLevel::class, 'difficulty_level_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function exerciseBiomechanics()
    {
        return $this->belongsTo(ExerciseBiomechanics::class, 'exercise_biomechanics_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function exerciseForceVector()
    {
        return $this->belongsTo(ExerciseForceVector::class, 'exercise_force_vector_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id');
    }

    public function muscle()
    {
        return $this->belongsTo(Muscle::class, 'muscle_id');
    }

    public function muscleGroups()
    {
        return $this->belongsToMany(MuscleGroup::class)->wherePivot('is_additional_muscle_group', false);
    }

    public function additionalMuscleGroups()
    {
        return $this->belongsToMany(MuscleGroup::class)->wherePivot('is_additional_muscle_group', true);
    }

    public function replacementExercises()
    {
        return $this->belongsToMany(
            __CLASS__,
            'exercise_replacement_exercise',
            'exercise_id',
            'replacement_exercise_id'
        );
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'exercise_equipment');
    }

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_exercise');
    }
}
