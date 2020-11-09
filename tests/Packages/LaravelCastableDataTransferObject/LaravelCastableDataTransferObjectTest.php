<?php

namespace Tests\Packages\LaravelCastableDataTransferObject;

use App\Packages\CastableDataTransferObject\Models\UserWithCastableDataTransferObject as User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


/**
 * @testdox Laravel Castable DTO
 * @description This package gives you an extended version of Spatie's DataTransferObject class, called CastableDataTransferObject.
 * Under the hood it implements Laravel's Castable interface with a Laravel custom cast that handles serializing between the DataTransferObject (or a compatible array) and your JSON database column.
 */
class LaravelCastableDataTransferObjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @description You pass either an instance of your Address class, or even just an array with a compatible structure. It will automatically be cast between your class and JSON for storage and the data will be validated on the way in and out.
     */
    public function casts_json_objects_as_data_transfer_objects(): void
    {
        $user = enlighten(function () {
            return User::create([
                'name' => 'Jane Jones',
                'email' => 'jane@email.test',
                'password' => bcrypt('password'),
                'address' => [
                    'street' => '1640 Riverside Drive',
                    'suburb' => 'Hill Valley',
                    'state' => 'California',
                ],
            ]);
        });

        $fullAddress = enlighten(function () use ($user) {
            return $user->address->fullAddress();
        });

        $this->assertCount(1, User::where('address->suburb', 'Hill Valley')->get());
        $this->assertSame($user->address->street, '1640 Riverside Drive');
        $this->assertSame($user->address->suburb, 'Hill Valley');
        $this->assertSame($user->address->state, 'California');
        $this->assertSame('1640 Riverside Drive, Hill Valley - California', $fullAddress);
    }
}
