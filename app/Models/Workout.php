<?php

namespace App\Models;

use Eloquent as Model;

/**
 * // toDo: set only fillable fields "WorkoutSet" block. And all other in WorkoutGet block.
 *
 * @SWG\Definition (
 *      definition="WorkoutSet",
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
 *          property="training_type_id",
 *          description="training_type_id",
 *          type="integer",
 *          format="int32"
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
 *  definition="WorkoutGet",
 *  allOf={
 *    @SWG\Schema(ref="#/definitions/WorkoutSet"),
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
 *          property="training_type_id",
 *          description="training_type_id",
 *          type="integer",
 *          format="int32"
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
 * @property string|null $name
 * @property int $author_id
 * @property int $training_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\TrainingType $trainingType
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout whereTrainingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Workout extends Model
{

    public $table = 'workouts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'name',
        'author_id',
        'duration',
        'training_type_id'
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
        'duration' => 'integer',
        'training_type_id' => 'integer'
    ];

    /**
     * Validation rules for create Model
     *
     * @var array
     */
    public static $create_rules = [
        'name' => 'required',
        'author_id' => 'required',
        'duration' => 'required',
        'training_type_id' => 'required'
    ];

    /**
     * Validation rules for update Model
     *
     * @var array
     */
    public static $update_rules = [
        'name' => 'required',
        'author_id' => 'required',
        'duration' => 'required',
        'training_type_id' => 'required'
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
    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id');
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercise');
    }

    public function trainingPacks()
    {
        return $this->belongsToMany(TrainingPack::class, 'training_pack_workout');
    }
}
