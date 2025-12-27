# Ratings Database Setup

## Error Explanation
You are receiving the error `Table 'ecommerce.ratings' doesn't exist` because the `ratings` table has not been created in your database yet. The `submit_review.php` script tries to insert data into this table, but it cannot find it.

## Solution
Please run the following SQL command in your database (e.g., using phpMyAdmin) to create the necessary table.

### SQL Command to Create `ratings` Table

```sql
CREATE TABLE `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `rating_value` int(11) NOT NULL,
  `comment` text NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp(),
  `image_urls` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Setup Instructions
1. Open **phpMyAdmin**.
2. Select your database (e.g., `ecommerce`).
3. Click on the **SQL** tab.
4. Paste the code above into the text box.
5. Click **Go**.

After running this, try submitting a review again.
