CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `sku` varchar(128) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `product_type` varchar(128) NOT NULL,
  `product_attribute` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
