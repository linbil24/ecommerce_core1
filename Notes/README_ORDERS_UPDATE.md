# Orders Database Update for Images

To display product images in your Order History, we need to add an `image_url` column to your existing `orders` table.

## SQL Command
Run this command in **phpMyAdmin** (SQL tab):

```sql
ALTER TABLE orders ADD COLUMN image_url VARCHAR(255) DEFAULT 'default_product.png';
```

This will allow the system to save and retrieve the product image for each order.
