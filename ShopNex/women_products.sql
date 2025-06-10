-- Kadın kategorisi için ürünler ekleme
-- Kategori ID 1 = Kadın

-- Kadın Ürünleri - Her ürün için başlığa uygun Unsplash görseli
INSERT INTO products (title, description, price, image, stock, category_id) VALUES
-- Elbiseler
('Kadın Siyah Elbise', 'Şık siyah elbise, özel günler için ideal', 889.99, 'https://images.unsplash.com/photo-1646831055965-d5b0c80393ad?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8d29tZW4lMjBibGFjayUyMGRyZXNzfGVufDB8fDB8fHww', 35, 1),
('Kadın Çiçekli Elbise', 'Yazlık çiçek desenli elbise, rahat kesim', 949.99, 'https://images.unsplash.com/photo-1715852700550-6436320162e6?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Rmxvd2VyJTIwZHJlc3N8ZW58MHx8MHx8fDA%3D', 40, 1),
('Kadın Mavi Elbise', 'Deniz mavisi şık elbise, günlük kullanım', 769.99, 'https://images.unsplash.com/photo-1607624461245-99225cf482e8?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Ymx1ZSUyMGRyZXNzfGVufDB8fDB8fHww', 30, 1),
('Kadın Kırmızı Elbise', 'Göz alıcı kırmızı elbise, parti için', 719.99, 'https://images.unsplash.com/photo-1612336307429-8a898d10e223?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cmVkJTIwZHJlc3N8ZW58MHx8MHx8fDA%3D', 25, 1),

-- Bluzlar ve Gömlekler
('Kadın Beyaz Bluz', 'Klasik beyaz bluz, iş hayatı için', 479.99, 'https://images.unsplash.com/photo-1600328759671-85927887458d?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8d29tZW4lMjB3aGl0ZSUyMGJsdXp8ZW58MHx8MHx8fDA%3D', 50, 1),
('Kadın İpek Gömlek', 'Lüks ipek gömlek, şık ve rahat', 799.99, 'https://images.unsplash.com/photo-1589810635657-232948472d98?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8d29tZW4lMjBzaGlydHxlbnwwfHwwfHx8MA%3D%3D', 20, 1),


-- Pantolon ve Şortlar
('Kadın Gri Pantolon', 'Yüksek bel Gri pantolon, slim fit', 729.99, 'https://images.unsplash.com/photo-1570653321586-3bb42aaee967?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8d29tZW4lMjBibGFjayUyMHBhbnRzfGVufDB8fDB8fHww', 40, 1),
('Kadın Jean Pantolon', 'Vintage mavi jean, yüksek bel', 639.99, 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 60, 1),
('Kadın Yazlık Şort', 'Rahat yazlık şort, pamuklu kumaş', 769.99, 'https://images.unsplash.com/photo-1585145197502-8f36802f0a26?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8d29tZW4lMjBzdW1tZXIlMjBzaG9ydHN8ZW58MHx8MHx8fDA%3D', 55, 1),

-- Kazak ve Hırkalar
('Kadın Pembe Kazak', 'Yumuşak pembe kazak, kış için ideal', 519.99, 'https://images.unsplash.com/photo-1606416835675-b4f110ed6918?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8cGluayUyMHN3ZWF0c2hpcnR8ZW58MHx8MHx8fDA%3D', 35, 1),
('Kadın Gri Hırka', 'Uzun gri hırka, çok amaçlı kullanım', 759.99, 'https://images.unsplash.com/photo-1742392133846-a8b416e81661?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8Z3JleSUyMGNhcmRpZ2FufGVufDB8fDB8fHww', 30, 1),
('Kadın Beyaz Triko', 'Klasik beyaz triko, şık ve sade', 999.99, 'https://images.unsplash.com/photo-1661181402854-8c9408409e9f?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8d2hpdGUlMjBzd2VhdHNoaXJ0fGVufDB8fDB8fHww', 40, 1),

-- Ceketler
('Kadın Blazer Ceket', 'Siyah blazer ceket, ofis için', 849.99, 'https://images.unsplash.com/photo-1646178071012-7bf3efe0ddfa?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c2l5YWglMjBibGF6ZXIlMjBjZWtldHxlbnwwfHwwfHx8MA%3D%3D', 25, 1),
('Kadın Denim Ceket', 'Vintage denim ceket, casual', 829.99, 'https://images.unsplash.com/photo-1639497108415-07fe78086a56?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8d29tZW4lMjBicm93biUyMGNvYXR8ZW58MHx8MHx8fDA%3D', 35, 1),
('Kadın Kırmızı Mont', 'Şık kırmızı mont, kış için', 999.99, 'https://images.unsplash.com/photo-1703718130225-1b59e4eb8860?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8d29tZW4lMjByZWQlMjBjb2F0fGVufDB8fDB8fHww', 20, 1),

-- Ayakkabılar
('Kadın Topuklu Ayakkabı', 'Siyah topuklu ayakkabı, 7cm', 779.99, 'https://images.unsplash.com/photo-1627141792925-eddee39cf275?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8a2FkJUM0JUIxbiUyMHRvcHVrbHUlMjBheWFrbGFiJUM0JUIxJTIwc2l5YWh8ZW58MHx8MHx8fDA%3D', 30, 1),
('Kadın Beyaz Spor Ayakkabı', 'Rahat beyaz spor ayakkabı', 749.99, 'https://images.unsplash.com/photo-1592771404380-467f535c7c4f?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8a2FkJUM0JUIxbmJleWF6JTIwc3BvciUyMGF5YWtrYWIlQzQlQjF8ZW58MHx8MHx8fDA%3D', 45, 1),('Kadın Bej Babet', 'Günlük bej babet, rahat', 689.99, 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 50, 1),
('Kadın Çizme', 'Siyah diz altı çizme, kış için', 269.99, 'https://images.unsplash.com/photo-1722467180352-8ef08abe5891?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8a2FkJUM0JUIxbiUyMHNpeWFoJTIwYm9vdHxlbnwwfHwwfHx8MA%3D%3D', 25, 1),

-- Aksesuarlar
('Kadın Deri Çanta', 'Lüks deri çanta, büyük boy', 799.99, 'https://images.unsplash.com/photo-1552256028-c51f32398295?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8d29tZW4lMjBsZWF0aGVyJTIwYmFnfGVufDB8fDB8fHww', 20, 1),
('Kadın İnci Kolye', 'Şık inci kolye, özel günler için', 159.99, 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8UGVhcmwlMjBuZWNrbGFjZXxlbnwwfHwwfHx8MA%3D%3D', 15, 1),
('Kadın Altın Küpe', 'Zarif altın küpe, günlük kullanım', 199.99, 'https://images.unsplash.com/photo-1721722224616-447ed06c02e1?w=1400&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8d29tZW4lMjBnb2xkJTIwZWFycmluZ3N8ZW58MHx8MHx8fDA%3D', 30, 1),
('Kadın Deri Kemer', 'İnce deri kemer, siyah', 259.99, 'https://images.unsplash.com/photo-1599926182149-175622a1bd8b?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8d29tZW4lMjBsZWF0aGVyJTIwYmVsdHxlbnwwfHwwfHx8MA%3D%3D', 40, 1),
('Kadın Güneş Gözlüğü', 'Trend güneş gözlüğü, UV korumalı', 129.99, 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 35, 1); 