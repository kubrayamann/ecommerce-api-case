# 🛒 Sipariş ve İndirim API Servisi

Bu proje, Laravel kullanılarak geliştirilmiş bir sipariş yönetim sistemi API'sidir. Sipariş oluşturma, ürün yönetimi ve çeşitli indirim kuralları içerir.

## 🔧 Kurulum Adımları

```bash
git clone <repo-url>
cd ecommerce-api
```

```bash
docker-compose up --build
``` 

Bu projede Docker kullanılarak geliştirilmiştir. 

- PHP bağımlılıkları otomatik olarak yüklenir (composer install)

- Veritabanı migrasyonları ve seed işlemi otomatik olarak yapılır (php artisan migrate --seed)

- Laravel uygulaması ve veritabanı hazır hale gelir.


## 🧪 Postman Koleksiyonu
Bu proje için hazırlanmış Postman koleksiyonu, API uç noktalarını test etmenizi sağlar. Koleksiyon, sipariş oluşturma, listeleme ve indirim hesaplama gibi işlemleri içerir.

Koleksiyonu [buradan indirebilirsiniz](<ECommerceApi.postman_collection.json>).

## 📦 Seed Bilgisi
Proje başlangıcında örnek verilerle doldurulması için `DatabaseSeeder` sınıfı kullanılmıştır. Bu sınıf, veritabanını başlangıç verileriyle doldurmak için gerekli seed dosyalarını çağırır. Seeder dosyaları çalıştırıldığında aşağıdaki veritabanı tabloları oluşturulur:
- Müşteri verileri (customers)
- Ürün verileri (products)
- Sipariş verileri (orders)
- Sipariş detayları (order_items)

## 📉 Uygulanan İndirim Kuralları
Aşağıda, uygulanan indirim kuralları ve açıklamaları bulunmaktadır:

| İndirim Kuralı | Açıklama |
|----------------|----------|
| 10_PERCENT_OVER_1000 | Sipariş toplamı 1000₺ üzerindeyse %10 indirim |
| BUY_5_GET_1 | 2 ID’li kategoriden 6 ürün alındığında 1 bedava |
| 20_PERCENT_CHEAPEST_CATEGORY_1 | 1 ID’li kategoriden 2+ ürün alındığında en ucuz üründe %20 indirim |

İndirim kuralları, sipariş oluşturulurken otomatik olarak uygulanır. Her sipariş için uygun indirimler hesaplanır ve toplam tutara yansıtılır.
İlgili indirim kuralları, `App\Services\DiscountService` sınıfında tanımlanmıştır. Sabitler `App\Constants\DiscountReasons` sınıfında tutulur.

## 📚 Kullanım
API'yi kullanmak için aşağıdaki uç noktaları kullanabilirsiniz:

### Siparişler
- `GET /api/orders` - Tüm siparişleri listele
- `POST /api/orders` - Yeni sipariş oluşturma işlemi (indirim kuralları otomatik uygulanır)
- `DELETE /api/orders/{id}` - Siparişi sil

### İndirim Kuralları
- `GET /api/discounts/{id}` - İndirim kuralını hesapla

## 👨‍💻 Geliştirici

Kübra Yaman
- [GitHub](https://github.com/kubrayamann)
- [Email](mailto:ymn.kubra@gmail.com)
