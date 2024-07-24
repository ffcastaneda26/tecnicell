<?php

namespace App\Observers;

use App\Models\InvMovement;
use App\Models\KeyMovement;
use App\Models\WarehouseProduct;

class InvMovementObserver
{
    public $originalValues;
    /*+---------------------------------------------------------------------------------------------------------+
      |   Actualiza segpun el tipo de clave de movimiento  y revisa los puntos de existencia                    |
      +---------+-----------+-------------------+---------------------------------------------------------------+
      | Tipo    |   stock   |  stock_disponible |  average_cost | stock_min |   stock_max   |   stock_reorder   |
      +---------+-----------+-------------------+---------------------------+---------------+-------------------+
      | Entrada |  Suma     |   Suma            |   Actualiza   |           |   Revisa      |                   |
      | Salida  |  Resta    |   Resta           |               |   Revisa  |               |   Revisa          |
      +---------+-----------+-------------------+---------------------------+---------------+-------------------+
      | Se revisan los métodos: Creado, Actualizado, Eliminado haciendo lo que corresponda en cada uno de ellos |
      +---------+-----------+-------------------+---------------------------+---------------+-------------------+
     */
    public function created(InvMovement $invMovement): void
    {
        $warehouse_product_record = WarehouseProduct::where('warehouse_id', $invMovement->warehouse_id)
            ->where('product_id', $invMovement->product_id)
            ->first();

        if ($invMovement->key_movement->type == 'I' && $invMovement->key_movement->require_cost) {
            self::calculate_average_cost($warehouse_product_record, $invMovement->quantity, $invMovement->cost);
        }

        if ($invMovement->key_movement->short == 'Comp' || $invMovement->key_movement->short == 'Buy') {
            $warehouse_product_record->last_purchase_price = $invMovement->cost;
        }
        self::update_stocks($warehouse_product_record, $invMovement->quantity, $invMovement->key_movement->type);
        // TODO:: Revisar puntos máximo y mínimo como el punto de reorden

    }


    /**
     * Summary of updated
     * @param \App\Models\InvMovement $invMovement
     * @return void
     */
    public function updated(InvMovement $invMovement): void
    {

    }

    public function updating(InvMovement $invMovement): void
    {

        if ($invMovement->isDirty('quantity') || $invMovement->isDirty('cost')) {
            $warehouse_product_record = $this->read_warehouse_product($invMovement);
            $originalValues = $invMovement->getOriginal();
            $previous_cost = $originalValues['cost'];
            $previous_quantity = $originalValues['quantity'];
            $previous_total_cost = $warehouse_product_record->total_cost;
            $amount_previous = $previous_quantity * $previous_cost;
            $amount_new = $invMovement->quantity * $invMovement->cost;
            $new_total_cost = $previous_total_cost - $amount_previous + $amount_new;
            $new_stock = $warehouse_product_record->stock += $invMovement->quantity - $previous_quantity;
            $new_average_cost = $new_total_cost / $new_stock;
            $real_quantity = $invMovement->quantity - $previous_quantity;
            $warehouse_product_record->stock_available += $real_quantity;
            $warehouse_product_record->average_cost = $new_average_cost;
            $warehouse_product_record->save();
        }
    }

    public function deleting(InvMovement $invMovement): void
    {

    }
    /**
     * Handle the InvMovement "deleted" event.
     */
        public function deleted(InvMovement $invMovement): void
    {
        $warehouseProduct = $this->read_warehouse_product($invMovement);

        $new_stock = $invMovement->key_movement->type == 'I' ? $warehouseProduct->stock - $invMovement->quantity : $warehouseProduct->stock + $invMovement->quantity;
        $new_total = $invMovement->key_movement->type == 'I' ? $warehouseProduct->total_cost - $invMovement->amount : $warehouseProduct->total_cost + $invMovement->amount;
        $new_average_cost = $new_total /$new_stock ;
        $warehouseProduct->average_cost = $new_average_cost;
        $warehouseProduct->stock = $new_stock;
        $warehouseProduct->stock_available = $new_stock;
        $warehouseProduct->save();
    }

    private function calculate_average_cost(WarehouseProduct $warehouseProduct, $quantity, $cost)
    {
        $previous_total_cost = ($warehouseProduct->stock * $warehouseProduct->average_cost) + ($quantity * $cost);
        $new_stock = $warehouseProduct->stock + $quantity;
        $warehouseProduct->average_cost = $previous_total_cost / $new_stock;
        $warehouseProduct->save();
    }

    private function update_stocks(WarehouseProduct $warehouseProduct, $quantity, $type = 'I')
    {
        if ($type == 'O') {
            $quantity *= -1;
        }
        $warehouseProduct->stock += $quantity;
        $warehouseProduct->stock_available += $quantity;
        $warehouseProduct->save();
    }

    private function read_warehouse_product($invMovement): WarehouseProduct
    {
        return WarehouseProduct::where('warehouse_id', $invMovement->warehouse_id)
            ->where('product_id', $invMovement->product_id)
            ->first();
    }

}
