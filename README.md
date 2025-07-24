# DişHane – Diş Kliniği Yönetim Sistemi

DişHane, küçük ve orta ölçekli diş klinikleri için geliştirilmiş bir web tabanlı yönetim sistemidir. Klinik içi operasyonları dijitalleştirmek ve kullanıcı dostu bir arayüzle kolaylaştırmak için tasarlanmıştır.

## Özellikler
- Kullanıcı rolleri (Rol bazlı yetkilendirme):
• Admin
• Doktor
• Sekreter
• Hasta

- Randevu Yönetimi
• Sekreterin doktor için randevu saatleri belirlemesi
• Hastaların müsait saatleri görüp randevu oluşturması
• Doktorun randevu durumlarını güncellemesi (iptal/tamamlandı)

- Stok Takibi
• Ürün girişi ve doktorlar tarafından yapılan malzeme kullanımı
• Sekreter panelinde günlük stok kullanımı özeti
• Stok grafiği ile görsel takip

- Hasta Kayıt ve Geçmiş Takibi
• Hasta bazlı işlem geçmişi görüntüleme
• Planlanan işlemlerin eklenmesi ve notlanması

- Giriş/Kayıt ve Yetkilendirme Sistemi
• Farklı kullanıcılar için özel paneller
• Güvenli oturum yönetimi

## Kullanılan Teknolojiler
- Backend: PHP (MVC yapısı)
- Frontend: HTML, CSS, JavaScript, Ajax
- Veritabanı: MySQL (phpMyAdmin ile yönetim)
- Araçlar: Visual Studio Code, XAMPP

## Kurulum
1. Bu projeyi htdocs klasörüne taşıyın (XAMPP/MAMP için).

2. Veritabanı dosyasını phpMyAdmin üzerinden içe aktarın.
   
3. config/config.php dosyasındaki veritabanı ayarlarını yapın.
   
4. Tarayıcınızda şu adrese gidin: http://localhost/DisHane/public

## Geliştirici
- **Sena Nur Özdemir** – [GitHub](https://github.com/senathecoder)
