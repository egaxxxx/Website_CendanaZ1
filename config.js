// Konfigurasi website CV. Cendana Travel

// Data perusahaan
const KONFIGURASI_PERUSAHAAN = {
    name: 'Cv. Cendana Travel',
    whatsapp: '6285821841529',
    instagram: '@cendanatravel_official',
    email: 'info@cendanatravel.com',
    address: 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang\nKota Samarinda, Kalimantan Timur 75127',
    hours: 'Senin - Minggu: 08.00 - 22.00 WIB',
    description: 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana di depan masjid, kini kami telah berkembang dengan kantor cabang di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur.'
};

const COMPANY_CONFIG = KONFIGURASI_PERUSAHAAN;

// Data transportasi default
const DATA_TRANSPORTASI_DEFAULT = {
    pesawat: [
        {
            id: 1,
            name: 'Lion Air',
            logo: 'pesawat/Lionair.png',
            route: 'Penerbangan domestik terpercaya',
            price: 'Rp 450.000 - Rp 850.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 2,
            name: 'Garuda Indonesia',
            logo: 'pesawat/Garuda.png',
            route: 'Maskapai nasional Indonesia',
            price: 'Rp 500.000 - Rp 1.200.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 3,
            name: 'Batik Air',
            logo: 'pesawat/Batik.png',
            route: 'Layanan premium dengan harga terjangkau',
            price: 'Rp 500.000 - Rp 950.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 4,
            name: 'Citilink',
            logo: 'pesawat/Citilink.png',
            route: 'Low cost carrier terbaik',
            price: 'Rp 350.000 - Rp 650.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 5,
            name: 'Sriwijaya Air',
            logo: 'pesawat/Sriwijaya.png',
            route: 'Jangkauan luas ke seluruh Indonesia',
            price: 'Rp 400.000 - Rp 750.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 6,
            name: 'Pelita Air',
            logo: 'pesawat/Pelita.png',
            route: 'Penerbangan charter dan regular',
            price: 'Rp 380.000 - Rp 680.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 7,
            name: 'Royal Brunei',
            logo: 'pesawat/RoyalBrunei.png',
            route: 'Penerbangan internasional ke Brunei',
            price: 'Rp 1.000.000 - Rp 1.800.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        },
        {
            id: 8,
            name: 'Singapore Airlines',
            logo: 'pesawat/Singapore.png',
            route: 'Premium airline ke Singapore',
            price: 'Rp 1.200.000 - Rp 2.500.000',
            transportType: 'pesawat',
            dateAdded: '2024-01-01'
        }
    ],
    kapal: [
        {
            id: 9,
            name: 'KM. Kelud',
            logo: 'kapal/kapallaut.png',
            route: 'Kapal penumpang antar pulau',
            price: 'Rp 250.000 - Rp 450.000',
            transportType: 'kapal',
            dateAdded: '2024-01-01'
        },
        {
            id: 10,
            name: 'Speedboat Express',
            logo: 'kapal/speedboat.png',
            route: 'Speedboat cepat dan nyaman',
            price: 'Rp 200.000 - Rp 350.000',
            transportType: 'kapal',
            dateAdded: '2024-01-01'
        }
    ],
    bus: [
        {
            id: 11,
            name: 'Bus Pariwisata',
            logo: 'bus/bus.png',
            route: 'Bus pariwisata dengan fasilitas lengkap',
            price: 'Rp 100.000 - Rp 250.000',
            transportType: 'bus',
            dateAdded: '2024-01-01'
        }
    ]
};

// Alias untuk kompatibilitas
const DEFAULT_TRANSPORT_DATA = DATA_TRANSPORTASI_DEFAULT;

// Data fasilitas default
const DATA_FASILITAS_DEFAULT = [
    {
        id: 1,
        name: 'Ruang Tunggu VIP',
        image: 'gallery/Screenshot 2025-10-28 014436.png',
        description: 'Ruang tunggu yang nyaman dengan AC, WiFi gratis, dan refreshment untuk kenyamanan Anda sebelum keberangkatan.',
        category: 'kantor',
        uploadDate: '2024-10-28',
        location: 'Kantor Pusat Samarinda'
    },
    {
        id: 2,
        name: 'Layanan Antar Jemput',
        image: 'gallery/Screenshot 2025-10-28 014729.png',
        description: 'Layanan antar jemput dari rumah ke terminal/bandara dengan kendaraan yang nyaman dan sopir berpengalaman.',
        category: 'layanan',
        uploadDate: '2024-10-28',
        location: 'Layanan Antar Jemput'
    },
    {
        id: 3,
        name: 'Customer Service 24/7',
        image: 'gallery/Screenshot 2025-10-28 014745.png',
        description: 'Tim customer service yang siap membantu Anda 24 jam sehari, 7 hari seminggu melalui WhatsApp dan telepon.',
        category: 'kantor',
        uploadDate: '2024-10-28',
        location: 'Kantor Pusat'
    },
    {
        id: 4,
        name: 'Fasilitas Premium',
        image: 'gallery/Screenshot 2025-10-28 014806.png',
        description: 'Fasilitas premium dengan berbagai kemudahan untuk memberikan pengalaman perjalanan yang tak terlupakan.',
        category: 'layanan',
        uploadDate: '2024-10-28',
        location: 'Armada Premium'
    },
    {
        id: 5,
        name: 'Layanan Konsultasi',
        image: 'gallery/Screenshot 2025-10-28 014817.png',
        description: 'Konsultasi perjalanan dengan tim ahli kami untuk merencanakan perjalanan impian Anda.',
        category: 'layanan',
        uploadDate: '2024-10-28',
        location: 'Kantor Cabang'
    },
    {
        id: 6,
        name: 'Booking Online',
        image: 'gallery/Screenshot 2025-10-28 014829.png',
        description: 'Sistem booking online yang mudah dan cepat untuk kemudahan pemesanan tiket perjalanan Anda.',
        category: 'sistem',
        uploadDate: '2024-10-28',
        location: 'Platform Digital'
    },
    {
        id: 7,
        name: 'Travel Insurance',
        image: 'gallery/Screenshot 2025-10-28 014853.png',
        description: 'Asuransi perjalanan komprehensif untuk melindungi Anda selama bepergian dengan tenang.',
        category: 'sistem',
        uploadDate: '2024-10-28',
        location: 'Layanan Asuransi'
    }
];

// Alias untuk kompatibilitas
const DEFAULT_FACILITIES_DATA = DATA_FASILITAS_DEFAULT;

// Data jenis transportasi
const DATA_JENIS_TRANSPORTASI_DEFAULT = [
    {
        key: 'pesawat',
        name: 'Pesawat',
        icon: 'icon icon-plane',
        imageLight: 'JenisTransportasi/pesawatterang.png',
        imageDark: 'JenisTransportasi/pesawatgelap.png',
        description: 'Transportasi udara yang cepat dan efisien untuk perjalanan jarak jauh'
    },
    {
        key: 'kapal',
        name: 'Kapal',
        icon: 'icon icon-ship',
        imageLight: 'JenisTransportasi/kapalterang.png',
        imageDark: 'JenisTransportasi/kapalgelap.png',
        description: 'Transportasi laut yang nyaman untuk perjalanan antar pulau dengan pemandangan indah'
    },
    {
        key: 'bus',
        name: 'Bus',
        icon: 'icon icon-bus',
        imageLight: 'JenisTransportasi/busterang.png',
        imageDark: 'JenisTransportasi/busgelap.png',
        description: 'Transportasi darat yang ekonomis dan terjangkau untuk perjalanan dalam kota dan antar kota'
    }
];

// Alias untuk kompatibilitas
const DEFAULT_TRANSPORT_TYPES = DATA_JENIS_TRANSPORTASI_DEFAULT;

// Ekspor data untuk Node.js
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        KONFIGURASI_PERUSAHAAN,
        DATA_TRANSPORTASI_DEFAULT,
        DATA_FASILITAS_DEFAULT,
        DATA_JENIS_TRANSPORTASI_DEFAULT,
        // Alias untuk kompatibilitas
        COMPANY_CONFIG: KONFIGURASI_PERUSAHAAN,
        DEFAULT_TRANSPORT_DATA: DATA_TRANSPORTASI_DEFAULT,
        DEFAULT_FACILITIES_DATA: DATA_FASILITAS_DEFAULT,
        DEFAULT_TRANSPORT_TYPES: DATA_JENIS_TRANSPORTASI_DEFAULT
    };
}