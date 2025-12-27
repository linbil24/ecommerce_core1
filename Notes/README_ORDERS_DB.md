# Orders Database Schema

To support the checkout and "Buy Now" functionality in `Submodules/Content-sale/buy-now.php`, a new table named `orders` is required.

**Note:** The current implementation in `buy-now.php` includes logic to automatically create this table if it does not exist. However, you can use the SQL command below to create it manually.

## Table Structure: `orders`

| Column | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT | Primary Key, Auto Increment | Unique identifier for each order |
| `user_id` | INT | NOT NULL | ID of the user placing the order |
| `product_name` | VARCHAR(255) | NOT NULL | Name of the product purchased |
| `quantity` | INT | NOT NULL | Quantity purchased |
| `price` | DECIMAL(10, 2) | NOT NULL | Unit price of the product |
| `total_amount` | DECIMAL(10, 2) | NOT NULL | Grand total (including shipping/tax) |
| `full_name` | VARCHAR(255) | NOT NULL | Recipient's full name |
| `phone_number` | VARCHAR(50) | NOT NULL | Recipient's contact number |
| `address` | TEXT | NOT NULL | Shipping address |
| `city` | VARCHAR(100) | NOT NULL | City |
| `postal_code` | VARCHAR(20) | NOT NULL | Postal/Zip Code |
| `payment_method` | VARCHAR(50) | NOT NULL | Selected payment method (e.g., COD, GCash) |
| `status` | VARCHAR(50) | Default 'Pending' | Order status (Pending, Completed, etc.) |
| `created_at` | TIMESTAMP | Default CURRENT_TIMESTAMP | Time when order was placed |

## SQL Command to Create Table

```sql
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
