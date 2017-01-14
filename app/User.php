<?php

namespace App;

use App\Entities\Department;
use Laravel\Spark\User as SparkUser;
use App\Entities\GroceryList;
use App\Entities\Recipe;
use App\Entities\RecipeCategory;
use Illuminate\Notifications\Notifiable;

class User extends SparkUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'date',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function groceryLists()
    {
        return $this->hasMany(GroceryList::class);
    }

    public function recipeCategories()
    {
        return $this->hasMany(RecipeCategory::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
