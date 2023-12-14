<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = [true, false];
        $tipe   = ['1','2','3'];
        // $wilayah= range(1,64);
        $kota   = ['Batam', 'Pekanbaru', 'Jakarta'];

        return [
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'=> Hash::make('123456'),
            'active'=> Arr::random($status),
            'tipe'=> Arr::random($tipe),
            'alamat'=> $this->faker->address,
            'telpon'=> $this->faker->phoneNumber,
            'profilePicture'=> $this->faker->imageUrl($width = 640, $height = 480),
            // 'wilayah_id'=>Arr::random($wilayah),
            'kota'=>Arr::random($kota),
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

// Untuk menjalankannya secara manual
// php artisan tinker
// NamaModel::factory()->count(1000)->create()
