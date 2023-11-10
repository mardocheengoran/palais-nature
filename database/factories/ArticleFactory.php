<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\User;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

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
            'content' => $this->faker->paragraphs(3, true),
            'link' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'link_video' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'resume' => $this->faker->text,
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'location' => '{}',
            'other' => '{}',
            'start_at' => $this->faker->dateTime(),
            'end_at' => $this->faker->dateTime(),
            'antidated' => $this->faker->dateTime(),
            'price_buy' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_new' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_old' => $this->faker->randomFloat(2, 0, 99999999.99),
            'quantity' => $this->faker->randomFloat(2, 0, 99999999.99),
            'status' => $this->faker->boolean,
            'enable' => $this->faker->boolean,
            'rubric_id' => Parameter::factory(),
            'audience_id' => Parameter::factory(),
            'setting_id' => Setting::factory(),
            'parent_id' => Article::factory(),
            'user_created' => User::factory(),
            'user_updated' => User::factory(),
            'published_at' => $this->faker->dateTime(),
            'deleted_at' => $this->faker->word,
        ];
    }
}
