<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockTransaction>
 */
class StockTransactionFactory extends Factory
{
    protected $data = [];
    protected $isType = false;
    protected $index = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $notes = [
            'Initial stock',
            'Shipment to customer',
            'Restocking order',
            'Order canceled by customer',
            'Bulk purchase',
            'Scheduled for shipment',
            'Warehouse delivery',
            'Express order shipment',
            'Incoming inventory',
            'Fulfillment order',
            'Overstock return',
            'Customer return processing',
            'Supply chain update',
            'Pending customer approval',
            'Large supplier order',
            'Shipped to distributor',
            'Restocked by team',
            'Standard delivery',
            'Bulk stock arrival',
            'Error in processing',
            'Incoming order confirmed',
            'Awaiting shipment',
            'Direct vendor supply',
            'Order rejected',
            'Received stock update',
            'Customer bulk request',
            'Stock arrival notice',
            'Priority delivery',
            'Additional stock ordered',
            'Last month sales'
        ];
         
        $type = in_array('in',array_column($this->data,'type')) ? $this->faker->randomElement(['in','out'])  : 'in' ;

        $status = in_array('completed',array_column($this->data, 'status'))?
         $this->faker->randomElement(['pending', 'completed', 'cancelled']) 
         : 
         'completed';

        // Hitung jumlah transaksi berdasarkan stok saat ini
        if ($type === 'in') {
            $product_id = Product::inRandomOrder()->first()->id;
            $qty = $this->faker->numberBetween(10, 100);
            // Masukkan product_id, type ('in'), quantity, dan status ke dalam variabel $data
            $this->data[] = [
                'product_id' => $product_id,
                'type' => 'in',
                'quantity' => $qty,
                'status' => $status
            ];
        } else {
            $product_id = $this->faker->randomElement(array_column($this->data,'product_id'));
            
            if($status == 'completed'){
                
                $in = array_filter($this->data, function ($transaction) use ($product_id) {
                    return $transaction['product_id'] == $product_id && $transaction['type'] === 'in' && $transaction['status'] === 'completed';
                });
                $in_quantity = array_sum(array_column($in, 'quantity'));
    
                // Hitung stok tersedia dengan mengurangi stok keluar dari stok masuk
                $out = array_filter($this->data, function ($transaction) use ($product_id) {
                    return $transaction['product_id'] == $product_id && $transaction['type'] === 'out' && $transaction['status'] === 'completed';
                });
                $out_quantity = array_sum(array_column($out, 'quantity'));
                $latest_quantity = max(0, $in_quantity - $out_quantity);
                $qty = $this->faker->numberBetween(0, $latest_quantity);
                $this->data[] = [
                    'product_id' => $product_id,
                    'type' => 'out',
                    'quantity' => $qty,
                    'status' => 'completed'
                ];
            }else{
                $qty = $this->faker->numberBetween(10, 100);
            }
        }
        $this->index += 1;

        if($status=='completed'){
            $stock = ProductStock::find($product_id);
            if ($stock) {
                $stock->increment('stock', $qty * ($type === 'in' ? 1 : -1));
            } else {
                ProductStock::create([
                    'product_id' => $product_id,
                    'stock' => $qty * ($type === 'in' ? 1 : -1),
                ]);
            }
        }

        return [
            'product_id' => $product_id,
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => $type,
            'quantity' => $qty,
            'date' => $this->faker->dateTimeBetween('2023-01-01', '2024-12-31')->format('Y-m-d'),
            'status' => $status,
            'notes' => $this->index,
        ];
    }
}
