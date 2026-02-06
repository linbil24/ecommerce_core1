# Cart Database Schema

To support the shopping cart functionality, a new table named `cart` has been added to the database.

## Table Structure: `cart`

| Column | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT | Primary Key, Auto Increment | Unique identifier for each cart entry |
| `user_id` | INT | NOT NULL | ID of the user who owns the cart item |
| `product_name` | VARCHAR(255) | NOT NULL | Name of the product |
| `price` | DECIMAL(10, 2) | NOT NULL | Price per unit |
| `image` | VARCHAR(255) | NOT NULL | Path to the product image |
| `quantity` | INT | Default 1 | Quantity of the product |
| `created_at` | TIMESTAMP | Default CURRENT_TIMESTAMP | Time when item was added |

## SQL Command to Create Table

```sql
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Notes
- The `user_id` should link to the `users` table `id` column.
- This table stores product details directly (denormalized) since a dedicated `products` table does not currently exist.
- Prices should be stored as numeric values (e.g., 100.00) without currency symbols.
