<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanySetting;

class CompanySettingSeeder extends Seeder
{
    public function run()
    {
        // Dữ liệu mẫu thay thế config
        $companyConfig = [
            'name' => [
                'full' => 'Công ty TNHH Tư vấn Thiết kế Kiến trúc và Nội thất An Phú',
                'brand' => 'An Phú',
                'international' => 'An Phu Architecture and Interior Design Consulting Company Limited',
            ],
            'contact' => [
                'email' => 'kientrucnoithat.anphu@gmail.com',
                'phone_1' => '0949 453 283',
                'phone_2' => '0969 317 331',
                'address_1' => 'Số 01, liền kề 18, KĐT Văn Khê',
                'address_2' => 'Thị trấn Hoàn Long, Hưng Yên',
            ],
            'business' => [
                'license_number' => '0108588362',
                'license_authority' => 'Sở KHĐT T.P. Hà Nội',
                'license_date' => '15/01/2019',
            ],
            'social_media' => [
                'facebook' => [
                    'url' => 'https://www.facebook.com/share/16aNn1KZ37/?mibextid=wwXIfr',
                    'icon' => 'fab fa-facebook-f',
                    'name' => 'Facebook',
                    'color' => '#1877f2',
                ],
                'tiktok' => [
                    'url' => 'https://www.tiktok.com/@anphudesign',
                    'icon' => 'fab fa-tiktok',
                    'name' => 'TikTok',
                    'logo' => 'assets/img/logo/logo_tiktok.png',
                    'color' => '#000000',
                ],
                'youtube' => [
                    'url' => 'https://www.youtube.com/@anphudesign',
                    'icon' => 'fab fa-youtube',
                    'name' => 'YouTube',
                    'color' => '#ff0000',
                ],
                'zalo' => [
                    'url' => 'https://zalo.me/0969317331',
                    'icon' => null,
                    'name' => 'Zalo',
                    'logo' => 'assets/img/logo/logo_zalo.png',
                    'color' => '#0068ff',
                ],
            ],
            'assets' => [
                'logo' => [
                    'main' => 'assets/img/logo/banner.jpg',
                    'favicon' => 'assets/img/logo/favicon.ico',
                    'footer' => 'assets/img/logo/banner.jpg',
                ],
                'certification' => [
                    'bocongthuong' => 'assets/img/logo/bocongthuong_thongbao.png',
                ],
                'background' => [
                    'footer' => 'assets/img/gallery/background_danmask_1.jpg',
                ],
            ],
            'map_1' => [
                'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4651.941213619061!2d105.76204787601887!3d20.9752479896129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134530013984bd5%3A0xa071284b1bd0393f!2sAn%20Ph%C3%BA%20Design!5e1!3m2!1svi!2s!4v1751625845553!5m2!1svi!2s',
                'coordinates' => [
                    'lat' => 20.9752479896129,
                    'lng' => 105.76204787601887,
                ],
            ],
            'map_2' => [
                'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d33853.79464127152!2d105.9599174885666!3d20.9113837101855!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a5503419c553%3A0x736a6edb8fe3f43c!2zSG_DoG4gTG9uZywgWcOqbiBN4bu5LCBIxrBuZyBZw6puLCBWaeG7h3QgTmFt!5e1!3m2!1svi!2s!4v1755242241297!5m2!1svi!2s',
                'coordinates' => [
                    'lat' => 20.9113849,
                    'lng' => 105.980566
                ],
            ],
            'working_hours' => [
                'text' => 'Thứ 2 - Thứ 6: 8:00 - 17:30 | Thứ 7: 8:00 - 12:00',
            ],
        ];
        
        CompanySetting::truncate();

        CompanySetting::create([
            // Company names
            'company_name' => $companyConfig['name']['full'],
            'company_brand' => $companyConfig['name']['brand'],
            'international_name' => $companyConfig['name']['international'],
            
            // Contact information
            'email' => $companyConfig['contact']['email'],
            'company_phone_1' => $companyConfig['contact']['phone_1'],
            'company_phone_2' => $companyConfig['contact']['phone_2'],
            'company_address_1' => $companyConfig['contact']['address_1'],
            'company_address_2' => $companyConfig['contact']['address_2'],
            
            // Business license
            'license_number' => $companyConfig['business']['license_number'],
            'license_authority' => $companyConfig['business']['license_authority'],
            'license_date' => $companyConfig['business']['license_date'],
            
            // Social media - chuyển đổi format
            'social_links' => [
                'facebook' => [
                    'url' => $companyConfig['social_media']['facebook']['url'],
                    'icon' => $companyConfig['social_media']['facebook']['icon'],
                    'name' => $companyConfig['social_media']['facebook']['name'],
                    'color' => $companyConfig['social_media']['facebook']['color'],
                ],
                'tiktok' => [
                    'url' => $companyConfig['social_media']['tiktok']['url'],
                    'icon' => $companyConfig['social_media']['tiktok']['icon'],
                    'name' => $companyConfig['social_media']['tiktok']['name'],
                    'logo' => $companyConfig['social_media']['tiktok']['logo'],
                    'color' => $companyConfig['social_media']['tiktok']['color'],
                ],
                'youtube' => [
                    'url' => $companyConfig['social_media']['youtube']['url'],
                    'icon' => $companyConfig['social_media']['youtube']['icon'],
                    'name' => $companyConfig['social_media']['youtube']['name'],
                    'color' => $companyConfig['social_media']['youtube']['color'],
                ],
                'zalo' => [
                    'url' => $companyConfig['social_media']['zalo']['url'],
                    'icon' => $companyConfig['social_media']['zalo']['icon'],
                    'name' => $companyConfig['social_media']['zalo']['name'],
                    'logo' => $companyConfig['social_media']['zalo']['logo'],
                    'color' => $companyConfig['social_media']['zalo']['color'],
                ],
            ],
            
            // Assets
            'logo_main' => $companyConfig['assets']['logo']['main'],
            'logo_favicon' => $companyConfig['assets']['logo']['favicon'],
            'logo_footer' => $companyConfig['assets']['logo']['footer'],
            'certification_bocongthuong' => $companyConfig['assets']['certification']['bocongthuong'],
            'background_footer' => $companyConfig['assets']['background']['footer'],
            
            // Maps
            'google_map' => $companyConfig['map_1'],
            'google_map_2' => $companyConfig['map_2'],
            
            // Working hours
            'working_hours' => $companyConfig['working_hours']['text'],
            
            // Default values
            'certificates' => [],
            'certificates_public_ids' => [],
        ]);
    }
}
