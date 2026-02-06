-- Database: `core1_marketph`
USE `core1_marketph`;

CREATE TABLE IF NOT EXISTS `shipping_zones` (
    `zone_id` INT(11) NOT NULL AUTO_INCREMENT,
    `region_name` VARCHAR(100) NOT NULL,
    `base_fee` DECIMAL(10,2) NOT NULL,
    `estimated_days_min` INT(11) NOT NULL,
    `estimated_days_max` INT(11) NOT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default data
INSERT INTO `shipping_zones` (`region_name`, `base_fee`, `estimated_days_min`, `estimated_days_max`) VALUES
('Metro Manila', 60.00, 2, 3),
('Luzon (Provincial)', 120.00, 3, 7),
('Visayas', 160.00, 5, 10),
('Mindanao', 180.00, 7, 14),
('Island Territories', 250.00, 10, 20);
