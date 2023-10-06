INSERT INTO category VALUES (1, 'produkIseng');
INSERT INTO category VALUES (2, 'isengLagi');
INSERT INTO category VALUES (3, 'masihIseng');

INSERT INTO product VALUES (1, 'produk1', 'default.jpg', 'ini adalah produk1', 1, 20000, 5);
INSERT INTO product VALUES (2, 'ini', 'default.jpg', 'ini adalah produk2', 1, 15000, 4);
INSERT INTO product VALUES (3, 'namanya', 'default.jpg', 'ini adalah produk3', 1, 30000, 5);
INSERT INTO product VALUES (4, 'yah', 'default.jpg', 'ini adalah produk4', 1, 5000, 5);
INSERT INTO product VALUES (5, 'juga', 'default.jpg', 'ini adalah produk5', 1, 20000000, 5);
INSERT INTO product VALUES (6, 'nyoba', 'default.jpg', 'ini adalah produk6', 1, 2000, 5);
INSERT INTO product VALUES (7, 'produk2', 'default.jpg', 'ini adalah produk7', 1, 8000, 5);
INSERT INTO product VALUES (8, 'produk3', 'default.jpg', 'ini adalah produk8', 1, 900000, 5);
INSERT INTO product VALUES (9, 'namanya2', 'default.jpg', 'ini adalah produk9', 2, 30000, 5);
INSERT INTO product VALUES (10, 'yah2', 'default.jpg', 'ini adalah produk10', 2, 50000, 5);
INSERT INTO product VALUES (11, 'juga2', 'default.jpg', 'ini adalah produk11', 2, 2989000, 5);
INSERT INTO product VALUES (12, 'nyoba2', 'default.jpg', 'ini adalah produk12', 2, 200830, 5);
INSERT INTO product VALUES (13, 'produk4', 'default.jpg', 'ini adalah produk13', 3, 80040, 5);
INSERT INTO product VALUES (14, 'produk5', 'default.jpg', 'ini adalah produk14', 3, 90063000, 5);
INSERT INTO product VALUES (15, 'Lorem Ipsum', 'default.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s', 3, 9999999, 200);

INSERT INTO buyHistory (idUser, idProduct, quantity, totalPrice, buyDate)
VALUES (1, 1, 2, 200, '2023-10-01'),
       (1, 2, 3, 300, '2023-10-02'),
       (2, 3, 1, 100, '2023-10-03');
       
INSERT INTO topUp (idUser, amount, date, status)
VALUES (1, 5000, '2023-10-01', 'Success'),
       (1, 10000, '2023-10-02', 'Success'),
       (2, 15000, '2023-10-03', 'Failed');