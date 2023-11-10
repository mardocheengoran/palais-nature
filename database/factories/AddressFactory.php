<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Country;
use App\Models\Setting;
use App\Models\User;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

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
            'location' => '{}',
            'content' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->boolean,
            'user_id' => User::factory(),
            'country_id' => Country::factory(),
            'setting_id' => Setting::factory(),
            'user_created' => User::factory(),
            'user_updated' => User::factory(),
            'deleted_at' => $this->faker->word,
        ];
    }
}
