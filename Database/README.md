# How to Setup the Database

To make the login work, you need to create the database and the `users` table.

## Step 1: Create Database
1. Go to **phpMyAdmin** (usually http://localhost/phpmyadmin).
2. Create a new database named **`ecommerce`**.

## Step 2: Create Users Table
1. Select the **`ecommerce`** database.
2. Go to the **SQL** tab.
3. Copy and paste the following SQL command and click **Go**:

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
);
```

## Step 3: Insert a Test User
To test the login immediately, run this SQL command to add a user:

```sql
INSERT INTO `users` (`email`, `password`, `name`) VALUES
('test@example.com', 'password123', 'Test User');
```

Now you can login with:
- **Email:** test@example.com
- **Password:** password123
- **Password:** password123

## Step 4: (Optional) Create Support Tickets Table
If the system doesn't create it automatically, you can run this SQL:

```sql
CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `priority` enum('Low','Medium','High','Urgent') DEFAULT 'Medium',
  `assigned_to` int(11) DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_number` (`ticket_number`),
  KEY `customer_id` (`customer_id`),
  KEY `assigned_to` (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
