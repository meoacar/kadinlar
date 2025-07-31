<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZodiacSignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zodiacSigns = [
            [
                'name' => 'Koç',
                'name_en' => 'Aries',
                'symbol' => '♈',
                'start_date' => '2024-03-21',
                'end_date' => '2024-04-19',
                'color_primary' => '#FFB3BA',
                'color_secondary' => '#FF9999',
                'element' => 'Ateş',
                'personality_traits' => json_encode([
                    'dominant', 'cesur', 'lider ruhlu', 'enerjik', 'hırslı', 'aceleci'
                ]),
                'strengths' => 'Liderlik kabiliyeti, cesaret, enerji, kararlılık, girişkenlik',
                'weaknesses' => 'Sabırsızlık, aceleclik, sinirli mizaç, inatçılık',
                'description' => 'Koç burcu kadınları doğal liderlerdir. Cesur, enerjik ve yeniliklere açık yapıları ile her zaman önde olmayı severler.',
                'order' => 1
            ],
            [
                'name' => 'Boğa',
                'name_en' => 'Taurus',
                'symbol' => '♉',
                'start_date' => '2024-04-20',
                'end_date' => '2024-05-20',
                'color_primary' => '#BAFFC9',
                'color_secondary' => '#90EE90',
                'element' => 'Toprak',
                'personality_traits' => json_encode([
                    'sabırlı', 'güvenilir', 'praktik', 'konfortu seven', 'inatçı', 'sanatsal'
                ]),
                'strengths' => 'Güvenilirlik, sabır, pratiklik, dayanıklılık, estetik zevk',
                'weaknesses' => 'İnatçılık, değişime direnç, materialci yaklaşım, kıskançlık',
                'description' => 'Boğa burcu kadınları istikrarı ve güvenliği seven, güvenilir ve sabırlı kişilerdir.',
                'order' => 2
            ],
            [
                'name' => 'İkizler',
                'name_en' => 'Gemini',
                'symbol' => '♊',
                'start_date' => '2024-05-21',
                'end_date' => '2024-06-20',
                'color_primary' => '#FFFFBA',
                'color_secondary' => '#FFFF99',
                'element' => 'Hava',
                'personality_traits' => json_encode([
                    'konuşkan', 'meraklı', 'değişken', 'sosyal', 'zeki', 'kararsız'
                ]),
                'strengths' => 'İletişim becerisi, uyum kabiliyeti, zeka, sosyallik, öğrenme yetisi',
                'weaknesses' => 'Kararsızlık, yüzeysellik, çabuk sıkılma, dağınık düşünce',
                'description' => 'İkizler burcu kadınları çok yönlü, sosyal ve iletişim konusunda yeteneklidirler.',
                'order' => 3
            ],
            [
                'name' => 'Yengeç',
                'name_en' => 'Cancer',
                'symbol' => '♋',
                'start_date' => '2024-06-21',
                'end_date' => '2024-07-22',
                'color_primary' => '#BAE1FF',
                'color_secondary' => '#87CEEB',
                'element' => 'Su',
                'personality_traits' => json_encode([
                    'duygusal', 'koruyucu', 'sezgisel', 'aile odaklı', 'hassas', 'geçmişe bağlı'
                ]),
                'strengths' => 'Empati, koruyuculuk, sezgisel güç, aile bağlılığı, şefkat',
                'weaknesses' => 'Aşırı duygusallık, geçmişe takılma, değişime direnç, incingenlik',
                'description' => 'Yengeç burcu kadınları duygusal derinlikleri ve koruyucu yapıları ile bilinirler.',
                'order' => 4
            ],
            [
                'name' => 'Aslan',
                'name_en' => 'Leo',
                'symbol' => '♌',
                'start_date' => '2024-07-23',
                'end_date' => '2024-08-22',
                'color_primary' => '#FFD700',
                'color_secondary' => '#FFA500',
                'element' => 'Ateş',
                'personality_traits' => json_encode([
                    'dramatik', 'gururlu', 'cömert', 'yaratıcı', 'lüks düşkünü', 'dikkat çekici'
                ]),
                'strengths' => 'Yaratıcılık, cömertlik, liderlik, karizma, özgüven',
                'weaknesses' => 'Gurur, dikkat arayışı, lüks düşkünlük, kibirlilik',
                'description' => 'Aslan burcu kadınları doğal karizmaları ve yaratıcı enerjileri ile dikkat çekerler.',
                'order' => 5
            ],
            [
                'name' => 'Başak',
                'name_en' => 'Virgo',
                'symbol' => '♍',
                'start_date' => '2024-08-23',
                'end_date' => '2024-09-22',
                'color_primary' => '#E6E6FA',
                'color_secondary' => '#DDA0DD',
                'element' => 'Toprak',
                'personality_traits' => json_encode([
                    'titiz', 'analitik', 'mükemmeliyetçi', 'hizmet odaklı', 'eleştirel', 'düzenli'
                ]),
                'strengths' => 'Analitik düşünce, titizlik, güvenilirlik, hizmet odaklılık',
                'weaknesses' => 'Aşırı eleştiricilik, mükemmeliyetçilik, endişelilik, detaylara takılma',
                'description' => 'Başak burcu kadınları titiz, analitik ve mükemmeliyetçi yapıları ile bilinirler.',
                'order' => 6
            ],
            [
                'name' => 'Terazi',
                'name_en' => 'Libra',
                'symbol' => '♎',
                'start_date' => '2024-09-23',
                'end_date' => '2024-10-22',
                'color_primary' => '#F0F8FF',
                'color_secondary' => '#B0C4DE',
                'element' => 'Hava',
                'personality_traits' => json_encode([
                    'dengeli', 'diplomatik', 'estetik', 'adalet odaklı', 'kararsız', 'uyumlu'
                ]),
                'strengths' => 'Diplomasi, estetik zevk, adalet duyguru, uyum kabiliyeti',
                'weaknesses' => 'Kararsızlık, çatışmadan kaçınma, başkalarına bağımlılık',
                'description' => 'Terazi burcu kadınları denge, uyum ve güzellik arayışında olan diplomatik kişilerdir.',
                'order' => 7
            ],
            [
                'name' => 'Akrep',
                'name_en' => 'Scorpio',
                'symbol' => '♏',
                'start_date' => '2024-10-23',
                'end_date' => '2024-11-21',
                'color_primary' => '#DDA0DD',
                'color_secondary' => '#9370DB',
                'element' => 'Su',
                'personality_traits' => json_encode([
                    'yoğun', 'gizemli', 'tutku dolu', 'sezgisel', 'dönüştürücü', 'kontrolcü'
                ]),
                'strengths' => 'Sezgisel güç, dönüştürme yetisi, derinlik, sadakat',
                'weaknesses' => 'Kontrolcülük, kıskançlık, intikamcılık, gizlilik',
                'description' => 'Akrep burcu kadınları yoğun duygusal derinlikleri ve gizemli yapıları ile bilinirler.',
                'order' => 8
            ],
            [
                'name' => 'Yay',
                'name_en' => 'Sagittarius',
                'symbol' => '♐',
                'start_date' => '2024-11-22',
                'end_date' => '2024-12-21',
                'color_primary' => '#F5DEB3',
                'color_secondary' => '#DEB887',
                'element' => 'Ateş',
                'personality_traits' => json_encode([
                    'özgür', 'maceracı', 'iyimser', 'felsefi', 'doğrucu', 'dürüst'
                ]),
                'strengths' => 'Özgürlük sevgisi, iyimserlik, macera ruhu, dürüstlük',
                'weaknesses' => 'Sorumsuzluk, taahhütten kaçınma, aşırı dürüstlük',
                'description' => 'Yay burcu kadınları özgürlük seven, maceracı ve iyimser kişilerdir.',
                'order' => 9
            ],
            [
                'name' => 'Oğlak',
                'name_en' => 'Capricorn',
                'symbol' => '♑',
                'start_date' => '2024-12-22',
                'end_date' => '2025-01-19',
                'color_primary' => '#D2B48C',
                'color_secondary' => '#BC9A6A',
                'element' => 'Toprak',
                'personality_traits' => json_encode([
                    'disiplinli', 'hırslı', 'sorumlu', 'geleneksel', 'sabırlı', 'ciddi'
                ]),
                'strengths' => 'Disiplin, sorumluluk, kararlılık, başarı odaklılık',
                'weaknesses' => 'Aşırı ciddiyik, katılık, karamsar bakış, işkoliklik',
                'description' => 'Oğlak burcu kadınları disiplinli, hırslı ve başarı odaklı kişilerdir.',
                'order' => 10
            ],
            [
                'name' => 'Kova',
                'name_en' => 'Aquarius',
                'symbol' => '♒',
                'start_date' => '2025-01-20',
                'end_date' => '2025-02-18',
                'color_primary' => '#B0E0E6',
                'color_secondary' => '#87CEEB',
                'element' => 'Hava',
                'personality_traits' => json_encode([
                    'orijinal', 'bağımsız', 'insancıl', 'yenilikçi', 'asi', 'detaşe'
                ]),
                'strengths' => 'Yaratıcılık, bağımsızlık, insancıllık, orijinallik',
                'weaknesses' => 'Asi ruh, soğukluk, kurallara karşı çıkma, değişkenlik',
                'description' => 'Kova burcu kadınları özgün düşünceleri ve bağımsız yapıları ile bilinirler.',
                'order' => 11
            ],
            [
                'name' => 'Balık',
                'name_en' => 'Pisces',
                'symbol' => '♓',
                'start_date' => '2025-02-19',
                'end_date' => '2025-03-20',
                'color_primary' => '#F5F5DC',
                'color_secondary' => '#E6E6FA',
                'element' => 'Su',
                'personality_traits' => json_encode([
                    'hayal gücü kuvvetli', 'empatik', 'sezgisel', 'sanatsal', 'fedakar', 'kaçış eğilimli'
                ]),
                'strengths' => 'Empati, hayal gücü, sanatsal yetenek, sezgisel güç',
                'weaknesses' => 'Kaçış eğilimi, aşırı ideallik, kararsızlık, manipleasyon',
                'description' => 'Balık burcu kadınları güçlü sezgileri ve empatik yapıları ile bilinirler.',
                'order' => 12
            ]
        ];

        foreach ($zodiacSigns as $sign) {
            \App\Models\ZodiacSign::create($sign);
        }
    }
}
