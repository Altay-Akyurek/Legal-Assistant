# ⚖️ Sanal Hukuk Asistanı (Omni-Bridge V10.0)

**Sanal Hukuk Asistanı**, kullanıcıların yaşadıkları olayları doğal dille anlatabildikleri ve bu olayların hangi anayasal haklar, hukuk kategorileri ve ilgili kanunlarla ilişkili olduğunu saptayan gelişmiş bir analiz platformudur. 

> [!IMPORTANT]
> Bu proje bir **bilgilendirme aracıdır**. Profesyonel hukuk danışmanlığı yerine geçmez. Kullanıcılara hak arama süreçlerinde rehberlik eder.

---

## 🚀 Öne Çıkan Özellikler

- **🤖 Omni-Bridge Analiz Motoru:** Hayatın her alanından (Trafik, Sağlık, Aile, Dijital vb.) 100+ senaryoyu saptayabilen anlamsal köprü.
- **🗺️ Anayasal Eşleştirme:** Girilen olayı Türkiye Cumhuriyeti Anayasası'ndaki ilgili maddelerle otomatik olarak ilişkilendirir.
- **📚 Sektörel Rehberler:** Tüketici hakları, iş hukuku, aile hukuku gibi alanlarda dinamik "Virtual Guide" (Sanal Rehber) desteği.
- **⚖️ Kanun Desteği:** 4721 (Medeni Kanun), 6502 (Tüketici), 4857 (İş Kanunu) gibi temel kanun maddeleriyle desteklenen analizler.
- **🛠️ Hyper-Resilience Mantığı:** Karmaşık cümle yapılarını ve anahtar kelimeleri anlamsal olarak normalize eden dayanıklı altyapı.
- **💎 Premium Tasarım:** Glassmorphism etkileriyle donatılmış, modern ve kullanıcı dostu arayüz.

---

## 🧠 Çalışma Mantığı ve Mimari

Proje, veriyi işlemek için çok katmanlı bir mantıksal süreç kullanır:

### 1. Anlamsal Normalizasyon (Semantic Normalization)
Kullanıcının girdiği metin (örn: "Ev sahibi depozitomu vermiyor") öncelikle `EventAnalysisService` tarafından işlenir. Bu aşamada:
- Metin küçük harfe dönüştürülür ve temizlenir.
- Günlük terimler (örn: "kovulma") teknik hukuk terimlerine ("is calisma", "tazminat") dönüştürülür.

### 2. Ağırlıklı Kategorizasyon (Weighted Categorization)
Sistem, normalize edilmiş metin içerisinden anahtar kelimeleri ayıklar ve veritabanındaki 14 farklı hukuk kategorisiyle (`right_categories`) karşılaştırır. Eşleşme oranlarına göre %0-100 arası bir "relevance score" (ilgi skoru) hesaplanır.

### 3. Anayasa ve Kanun Eşleşmesi
Eşleşen kategoriler üzerinden, o kategoriyle ilişkili olan anayasa maddeleri ve bu maddeleri destekleyen özel kanunlar (Supporting Laws) sorgulanır.

### 4. Dinamik Rehber Sunumu
Sistem, olaydaki bağlamı saptarsa kullanıcının doğrudan ne yapması gerektiğini söyleyen (örn: "THH'ye E-devlet üzerinden başvurun") bir rehber oluşturur.

---

## 🏗️ Teknik Mimari

- **Framework:** Laravel 12 (PHP 8.2+)
- **Veritabanı:** MySQL (İlişkisel Şema)
- **Frontend:** Blade Templates, Vanilla CSS (Premium Modern Theme), JS
- **Tasarım Deseni:** MVC + Service Layer (Business logic tamamen Service katmanındadır)

### Veritabanı Şeması
`setup_database.sql` dosyası ile kurulan yapı aşağıdaki ana tabloları içerir:
- `right_categories`: Hukuk alanları ve anahtar kelimeleri.
- `constitution_articles`: Anayasa maddeleri ve sadeleştirilmiş açıklamaları.
- `supporting_laws`: Yardımcı kanunlar ve ilgili maddeleri.
- `event_records`: Yapılan analizlerin anonim kayıtları.

---

## 🛠️ Kurulum

1. Depoyu klonlayın: `git clone https://github.com/Altay-Akyurek/Legal-Assistant.git`
2. Bağımlılıkları yükleyin: `composer install`
3. `.env` dosyasını oluşturun: `cp .env.example .env`
4. Veritabanı bilgilerini `.env` içine girin.
5. Veritabanını hazırlayın:
   - MySQL üzerinde bir veritabanı oluşturun.
   - Verileri içe aktarmak için: `php artisan migrate --seed` (Tavsiye edilen)
   - Veya `setup_database.sql` dosyasını manuel içeri aktarın.
6. Uygulama anahtarını oluşturun: `php artisan key:generate`
7. Sunucuyu başlatın: `php artisan serve`

> [!TIP]
> **Ücretsiz Kullanım:** Bu proje herhangi bir ücretli API (OpenAI, Gemini vb.) anahtarı gerektirmez. Kendi geliştirdiğimiz "Omni-Bridge" anlamsal eşleştirme motoru ile tamamen ücretsiz çalışır.

---

## 👨‍💻 Geliştirici
**Altay Akyurek** tarafından hukuk okuryazarlığını artırmak ve hak arama süreçlerini kolaylaştırmak amacıyla geliştirilmiştir.

---

## 📄 Lisans
Bu proje [MIT Lisansı](LICENSE) ile lisanslanmıştır.
