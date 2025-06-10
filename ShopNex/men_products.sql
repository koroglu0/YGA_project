-- Erkek kategorisi için ürünler ekleme
-- Kategori ID 2 = Erkek

-- Erkek Ürünleri - Her ürün için başlığa uygun görsel
INSERT INTO products (title, description, price, image, stock, category_id) VALUES
-- T-Shirt ve Polo Yaka
('Erkek Siyah Basic T-Shirt', 'Pamuklu siyah basic t-shirt, günlük kullanım için ideal', 89.99, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 50, 2),
('Erkek Beyaz Polo Yaka T-Shirt', 'Klasik beyaz polo yaka t-shirt, şık ve rahat', 129.99, 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 45, 2),
('Erkek Lacivert Uzun Kollu T-Shirt', 'Pamuklu lacivert uzun kollu t-shirt', 99.99, 'https://images.unsplash.com/photo-1581803118522-7b72a50f7e9f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40, 2),

-- Pantolon
('Erkek Siyah Klasik Pantolon', 'İş hayatı için siyah klasik pantolon', 199.99, 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40, 2),
('Erkek Mavi Jean Pantolon', 'Slim fit mavi jean pantolon, modern kesim', 169.99, 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 55, 2),
('Erkek Kargo Pantolon', 'Rahat kargo pantolon, çok cepli', 139.99, 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=75', 35, 2),

-- Kazak ve Sweatshirt
('Erkek Gri Kapüşonlu Sweatshirt', 'Pamuklu gri kapüşonlu sweatshirt', 149.99, 'https://images.unsplash.com/photo-1599645049717-e93e420b6726?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8bWVucyUyMGdyZXklMjBzd2VhdGVyfGVufDB8fDB8fHww', 45, 2),
('Erkek Siyah Kazak', 'Yünlü siyah kazak, kış için ideal', 199.99, 'https://images.unsplash.com/photo-1549170156-0be20d0958a4?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bWVucyUyMGJsYWNrJTIwc3dlYXRlcnxlbnwwfHwwfHx8MA%3D%3D', 30, 2),

-- Ceket ve Mont
('Erkek Siyah Blazer Ceket', 'Slim fit siyah blazer ceket, formal', 399.99, 'https://images.unsplash.com/photo-1637641185564-9edb317d6f65?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bWVucyUyMGJsYWNrJTIwYmxhemVyJTIwamFja2V0fGVufDB8fDB8fHww', 20, 2),
('Erkek Denim Ceket', 'Vintage mavi denim ceket', 179.99, 'https://images.unsplash.com/photo-1716231683024-c85536c2dd52?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fG1lbnMlMjBkZW5pbSUyMGphY2tldHxlbnwwfHwwfHx8MA%3D%3D', 30, 2),
('Erkek Kış Montu', 'Su geçirmez kış montu, kapüşonlu', 459.99, 'https://images.unsplash.com/photo-1614785342100-aec8c50dcc85?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bWVucyUyMHdpbnRlciUyMGNvYXR8ZW58MHx8MHx8fDA%3D', 15, 2),

-- Ayakkabı
('Erkek Siyah Klasik Ayakkabı', 'Deri siyah klasik ayakkabı, ofis için', 299.99, 'https://images.unsplash.com/photo-1642978599217-287d0345389d?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2xhc3NpYyUyMHNob2VzJTIwbWVufGVufDB8fDB8fHww', 25, 2),
('Erkek Beyaz Spor Ayakkabı', 'Günlük beyaz spor ayakkabı, rahat', 219.99, 'https://images.unsplash.com/photo-1608379894453-c6b729b05596?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bWVucyUyMHdoaXRlJTIwc25lYWtlcnN8ZW58MHx8MHx8fDA%3D', 40, 2),
('Erkek Kahverengi Bot', 'Deri kahverengi bot, kış için ideal', 349.99, 'https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bWVucyUyMGJyb3duJTIwYm9vdHN8ZW58MHx8MHx8fDA%3D', 20, 2),

-- Aksesuar
('Erkek Siyah Deri Kemer', 'Gerçek deri siyah kemer, metal tokali', 79.99, 'https://images.unsplash.com/photo-1664286022075-8e997e95bd17?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bGVhdGhlciUyMGJlbHR8ZW58MHx8MHx8fDA%3D', 60, 2),
('Erkek Deri Cüzdan', 'Siyah deri cüzdan, çok bölmeli', 119.99, 'https://images.unsplash.com/photo-1637868796504-32f45a96d5a0?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8bGVhdGhlciUyMHdhbGxldHxlbnwwfHwwfHx8MA%3D%3D', 35, 2); 