<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Category;

class Product extends Model
{
    /**
     * PRODUCT ATTRIBUTES
     * $this->attributes['id'] - int - contains the product primary key (id)
     * $this->attributes['name'] - string - contains the product name
     * $this->attributes['description'] - string - contains the product description
     * $this->attributes['image'] - string - contains the product image
     * $this->attributes['price'] - int - contains the product price
     * $this->attributes['created_at'] - timestamp - contains the product creation date
     * $this->attributes['updated_at'] - timestamp - contains the product update date
     * $this->items - Item[] - contains the associated items
     */

     public function category()
{
    return $this->belongsTo(Category::class);
}

protected $fillable = [
    'name',
    'description',
    'price',
    'image',
    'quantity_store',
];

    



    public static function validate($request)
    {
        $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric|gt:0",
            'quantity_store',
            'image' => 'image',
        ]);
    }


            public function getQuantityStore()
        {
            return $this->quantity_store;
        }

        public function setQuantityStore($quantity)
        {
            $this->quantity_store = $quantity;
        }


    public static function sumPricesByQuantities($products, $productsInSession)
    {
        $total = 0;
        foreach ($products as $product) {
            $total = $total + ($product->getPrice()*$productsInSession[$product->getId()]);
        }

        return $total;
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription()
    {
        return $this->attributes['description'];
    }

    public function setDescription($description)
    {
        $this->attributes['description'] = $description;
    }

    public function getImage()
    {
        return $this->attributes['image'];
    }

    public function setImage($image)
    {
        $this->attributes['image'] = $image;
    }

    public function getPrice()
    {
        return $this->attributes['price'];
    }

    public function setPrice($price)
    {
        $this->attributes['price'] = $price;
    }

    public function getCreatedAt()
    {
        return $this->attributes['created_at'];
    }

    public function setCreatedAt($createdAt)
    {
        $this->attributes['created_at'] = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->attributes['updated_at'];
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->attributes['updated_at'] = $updatedAt;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }



    public function discounts() {
    return $this->hasMany(Discount::class);
    }


    public function currentDiscount()
    {
        return $this->discounts()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->latest()
            ->first();
    }


    public function discountedPrice()
    {
        $discount = $this->currentDiscount();
        if ($discount) {
            return $this->price * (1 - $discount->rate);
        }
        return $this->price;
    }
    public function isDiscounted()
    {
        return $this->currentDiscount() !== null;
    }
    public function setSupplierId($supplier_id)
    
    {
        return $this->attributes['supplier_id']=$supplier_id;
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
