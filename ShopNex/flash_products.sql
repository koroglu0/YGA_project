-- Flaş Ürünler - Ana Sayfa için

-- Flaş Ürünleri Ekle (9 adet)
INSERT INTO products (title, description, price, image, stock, category_id) VALUES
-- Elektronik Flaş Ürünleri (category_id = 5)
('iPad Pro 11" M2 WiFi 128GB', 'Apple iPad Pro 11 inç M2 çip, Liquid Retina XDR', 28999.99, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 18, 5),
('AirPods Pro 2. Nesil', 'Aktif gürültü engelleme, USB-C şarj kutusu', 7999.99, 'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 35, 5),
('Samsung Galaxy Buds2 Pro', 'Premium wireless kulaklık, 360 Audio desteği', 4299.99, 'https://images.unsplash.com/photo-1590658165737-15a047b7ff40?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 28, 5),

-- Ev & Yaşam Flaş Ürünleri (category_id = 6)
('Tefal OptiGrill Elite', 'Akıllı ızgara, otomatik pişirme programları', 3999.99, 'https://images.unsplash.com/photo-1604152135912-04a022e23696?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 15, 6),
('Beko Buzdolabı A+ 540L', 'No Frost teknoloji, çift kapılı buzdolabı', 15999.99, 'https://images.unsplash.com/photo-1571175443880-49e1d25b2bc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 8, 6),
('Vestel Çamaşır Makinesi 9kg', 'A+++ enerji sınıfı, 1400 devir çamaşır makinesi', 8999.99, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 12, 6),

-- Spor Flaş Ürünleri (category_id = 3)
('Adidas Ultraboost 22', 'Koşu ayakkabısı, Boost teknoloji', 4599.99, 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 25, 3),
('Under Armour Spor Çantası', 'Su geçirmez spor çantası, 40L hacim', 899.99, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40, 3),

-- Kişisel Bakım Flaş Ürün (category_id = 4)
('Philips OneBlade Pro', 'Hibrit tıraş makinesi, kuru/ıslak kullanım', 1299.99, 'https://images.unsplash.com/photo-1564182379166-8fcfdda80151?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 30, 4); 