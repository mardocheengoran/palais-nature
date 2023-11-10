<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\User;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'content' => $this->faker->paragraphs(3, true),
            'quantity' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_ht' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_tax' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_delivery' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_discount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'price_final' => $this->faker->randomFloat(2, 0, 99999999.99),
            'planned_at' => $this->faker->dateTime(),
            'exacted_at' => $this->faker->dateTime(),
            'ip' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'status' => $this->faker->boolean,
            'relay_id' => Parameter::factory(),
            'delivery_mode_id' => Parameter::factory(),
            'payment_method_id' => Parameter::factory(),
            'deliveryman_id' => User::factory(),
            'address_id' => Address::factory(),
            'state_id' => Parameter::factory(),
            'customer_id' => User::factory(),
            'commercial_id' => User::factory(),
            'setting_id' => Setting::factory(),
            'user_created' => User::factory(),
            'user_updated' => User::factory(),
            'deleted_at' => $this->faker->word,
        ];
    }
}
