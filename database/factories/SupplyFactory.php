<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Setting;
use App\Models\Supply;
use App\Models\User;

class SupplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'type' => $this->faker->randomElement(["entr\u00e9e","sortie"]),
            'quantity' => $this->faker->randomFloat(2, 0, 99999999.99),
            'title' => $this->faker->sentence(4),
            'subtitle' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'content' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->boolean,
            'article_id' => Article::factory(),
            'agent_id' => User::factory(),
            'vendor_id' => User::factory(),
            'setting_id' => Setting::factory(),
            'user_created' => User::factory(),
            'user_updated' => User::factory(),
            'deleted_at' => $this->faker->word,
        ];
    }
}
