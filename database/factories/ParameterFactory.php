<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\TypeParameter;
use App\Models\User;

class ParameterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parameter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'rank' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence(4),
            'subtitle' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'icon' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'class' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'color' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'content' => $this->faker->paragraphs(3, true),
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'location' => '{}',
            'status' => $this->faker->boolean,
            'type_parameter_id' => TypeParameter::factory(),
            'parent_id' => Parameter::factory(),
            'setting_id' => Setting::factory(),
            'user_created' => User::factory(),
            'user_updated' => User::factory(),
            'deleted_at' => $this->faker->word,
        ];
    }
}
