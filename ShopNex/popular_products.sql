-- Ana Sayfa Popüler Ürünleri

-- Önce varolan genel ürünleri temizle (kategori 1 ve 2 harici)
DELETE FROM products WHERE (category_id IS NULL OR (category_id != 1 AND category_id != 2));

-- Popüler Ürünler - Ana Sayfa için çeşitli kategorilerden (12 ürün)
INSERT INTO products (title, description, price, image, stock, category_id) VALUES
-- Elektronik Ürünleri (category_id = 5)
('Apple iPhone 15 128GB', 'Yeni nesil iPhone 15, 128GB depolama, A17 Bionic çip', 45999.99, 'https://images.unsplash.com/photo-1592286473673-f5db09fb2a19?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 25, 5),
('Samsung 4K Smart TV 55"', '55 inç 4K UHD Smart TV, HDR desteği', 18999.99, 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 15, 5),
('Sony WH-1000XM4 Kulaklık', 'Noise cancelling wireless kulaklık', 8999.99, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 30, 5),

-- Ev & Yaşam Ürünleri (category_id = 6)
('Dyson V15 Kablosuz Süpürge', 'Gelişmiş filtreleme sistemi, 60 dakita kullanım', 12999.99, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 18, 6),
('Nespresso Kahve Makinesi', 'Kapsüllü espresso makinesi, otomatik süt köpürtücü', 5999.99, 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 22, 6),
('IKEA Modern Yemek Masası', '6 kişilik ahşap yemek masası, contemporary tasarım', 7499.99, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 8, 6),

-- Spor & Fitness Ürünleri (category_id = 3)
('Nike Air Max 270 Ayakkabı', 'Koşu ve günlük kullanım için ideal spor ayakkabı', 3299.99, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40, 3),
('Apple Watch Series 9 GPS', 'Fitness takibi, sağlık sensörleri, 45mm', 11999.99, 'https://images.unsplash.com/photo-1510017098667-27dfc7150acb?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 20, 3),
('Yoga Matı Premium 6mm', 'Kaymaz yüzey, taşıma çantası dahil', 899.99, 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 45, 3),

-- Kişisel Bakım Ürünleri (category_id = 4)
('Dyson Airwrap Saç Şekillendirici', 'Çok fonksiyonlu saç şekillendirici, 7 aksesuar', 19999.99, 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 10, 4),
('The Ordinary Cilt Bakım Seti', 'Niacinamide + Hyaluronic Acid serum seti', 799.99, 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 50, 4),

-- Genel/Diğer Ürünler (category_id = NULL)
('Starbucks Tumbler 473ml', 'Paslanmaz çelik termos bardak, soğuk/sıcak', 449.99, 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 80, NULL); 