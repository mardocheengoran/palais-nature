<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'moyen' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'token' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'content' => '{}',
            'price_ht' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_tax' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_discount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_final' => $this->faker->randomFloat(2, 0, 99999999.99),
            'status' => $this->faker->boolean,
            'invoice_id' => Invoice::factory(),
            'setting_id' => Setting::factory(),
            'user_created' => User::factory(),
            'user_updated' => User::factory(),
            'deleted_at' => $this->faker->word,
        ];
    }
}
