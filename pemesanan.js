// Script untuk halaman pemesanan

const bookingApp = {
    currentFilter: 'pesawat',
    servicesData: {},
    
    // Data untuk Kelas Perjalanan sesuai tipe transportasi
    kelasPerjalananData: {
        'pesawat': [
            { value: 'Ekonomi', label: 'Ekonomi (Economy)' },
            { value: 'Bisnis', label: 'Bisnis (Business)' },
            { value: 'Premium', label: 'Premium (First Class)' }
        ],
        'kapal': [
            { value: 'Reguler', label: 'Reguler' },
            { value: 'VIP', label: 'VIP' }
        ],
        'bus': [
            { value: 'Ekonomi', label: 'Ekonomi' },
            { value: 'Executive', label: 'Executive' }
        ]
    },
    // inisialisasi aplikasi
    init() {
        console.log('🚀 Booking App Initializing...');
        
        // Load data from config.js
        if (typeof DATA_TRANSPORTASI_DEFAULT !== 'undefined') {
            this.servicesData = DATA_TRANSPORTASI_DEFAULT;
            console.log('✅ Data loaded:', Object.keys(this.servicesData));
        } else {
            console.error('❌ DATA_TRANSPORTASI_DEFAULT not found');
            this.servicesData = { pesawat: [], kapal: [], bus: [] };
        }
        
        // Render initial cards
        this.renderCards('pesawat');
        
        // Setup event listeners
        this.setupEventListeners();
        
        console.log('✅ Booking App Ready');
    },
    
    // setup event listener
    setupEventListeners() {
        // Modal overlay click to close
        const modalOverlay = document.getElementById('bookingModal');
        if (modalOverlay) {
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) {
                    this.closeModal();
                }
            });
        }
        
        // ESC key to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modalOverlay.style.display === 'flex') {
                this.closeModal();
            }
        });
    },
    
    // ganti filter dan tampilkan data
    switchFilter(type) {
        console.log(`🔄 Switching to: ${type}`);
        this.currentFilter = type;
        
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.remove('active');
            if (tab.dataset.type === type) {
                tab.classList.add('active');
            }
        });
        
        // Update section title
        this.updateSectionTitle(type);
        
        // Render cards
        this.renderCards(type);
    },
    
    // update judul section
    updateSectionTitle(type) {
        const titles = {
            'pesawat': 'Pilihan Pesawat Terbaik',
            'kapal': 'Pilihan Kapal Terpercaya',
            'bus': 'Pilihan Bus Terbaik'
        };
        
        const count = (this.servicesData[type] || []).length;
        
        const titleEl = document.getElementById('sectionTitle');
        const subtitleEl = document.getElementById('sectionSubtitle');
        
        if (titleEl) {
            titleEl.textContent = titles[type] || 'Pilihan Transportasi';
        }
        
        if (subtitleEl) {
            subtitleEl.textContent = `${count} pilihan layanan tersedia untuk Anda`;
        }
    },
    
    // tampilkan card sesuai tipe
    renderCards(type) {
        console.log(`🔍 renderCards called with type: ${type}`);
        
        const container = document.getElementById('cardsContainer');
        console.log('🔍 Container element:', container);
        
        if (!container) {
            console.error('❌ Container #cardsContainer not found in DOM!');
            console.log('Available IDs:', Array.from(document.querySelectorAll('[id]')).map(el => el.id));
            return;
        }
        
        // Clear container
        container.innerHTML = '';
        console.log('✅ Container cleared');
        
        // Get services for this type
        const services = this.servicesData[type] || [];
        console.log(`📦 Rendering ${services.length} cards for ${type}`);
        console.log('Services data:', services);
        
        if (services.length === 0) {
            container.innerHTML = `
                <div class="no-services-message">
                    <div class="no-services-icon">
                        <i class="icon icon-info"></i>
                    </div>
                    <h3>Belum Ada Layanan</h3>
                    <p>Saat ini belum ada layanan ${type} yang tersedia.</p>
                </div>
            `;
            console.log('⚠️ No services available, showing empty message');
            return;
        }
        
        // Render each service card
        services.forEach((service, index) => {
            console.log(`Creating card ${index + 1}/${services.length}:`, service.name);
            const card = this.createCard(service);
            container.appendChild(card);
        });
        
        console.log(`✅ Successfully rendered ${services.length} cards to DOM`);
    },
    
    // buat card untuk setiap layanan
    createCard(service, type) {
        const card = document.createElement('div');
        card.className = 'transport-card';
        
        // ✅ Path sudah diperbaiki di PHP (pemesanan.php), tidak perlu tambah 'uploads/' lagi
        const logoPath = service.logo || this.getDefaultLogo(service.transportType);
        const iconClass = this.getIconClass(service.transportType);
        
        card.innerHTML = `
            <div class="transport-card-content">
                <div class="company-logo-wrapper">
                    <img src="${logoPath}" 
                         alt="${service.name}" 
                         class="company-logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-placeholder" style="display:none;">
                        <i class="icon ${iconClass}"></i>
                    </div>
                </div>
                
                <h3>${service.name}</h3>
                
                <div class="description">
                    ${service.route || 'Layanan transportasi terpercaya'}
                </div>
                
                <div class="price-range">
                    ${service.price || 'Hubungi untuk harga'}
                </div>
                
                <button class="btn-book-now" onclick="bookingApp.openModal('${this.escapeHtml(service.name)}', '${service.transportType}')">
                    <i class="icon icon-whatsapp"></i>
                    <span>Pesan Sekarang</span>
                </button>
            </div>
        `;
        
        return card;
    },
    
    // ambil logo default
    getDefaultLogo(type) {
        const logos = {
            'pesawat': 'uploads/pesawat/default-plane.png',
            'kapal': 'uploads/kapal/default-ship.png',
            'bus': 'uploads/bus/default-bus.png'
        };
        return logos[type] || 'uploads/default-transport.png';
    },
    
    // ambil icon sesuai tipe
    getIconClass(type) {
        const icons = {
            'pesawat': 'icon-plane',
            'kapal': 'icon-ship',
            'bus': 'icon-bus'
        };
        return icons[type] || 'icon-plane';
    },
    
    // escape html
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    },
    
    // buka modal booking
    openModal(serviceName, type) {
        console.log(`📋 Opening modal for: ${serviceName}, type: ${type}`);
        
        const modal = document.getElementById('bookingModal');
        if (!modal) {
            console.error('❌ Modal #bookingModal not found in DOM!');
            console.log('Available modals:', document.querySelectorAll('[id*="modal"]'));
            return;
        }
        
        console.log('✅ Modal found:', modal);
        
        // Set form values
        const selectedService = document.getElementById('selectedService');
        const selectedType = document.getElementById('selectedType');
        const displayServiceName = document.getElementById('displayServiceName');
        
        if (selectedService) selectedService.value = serviceName;
        if (selectedType) selectedType.value = type;
        if (displayServiceName) displayServiceName.textContent = serviceName;
        
        // Reset other fields
        const customerName = document.getElementById('customerName');
        const origin = document.getElementById('origin');
        const destination = document.getElementById('destination');
        const passengers = document.getElementById('passengers');
        const travelDate = document.getElementById('travelDate');
        const additionalMessage = document.getElementById('additionalMessage');
        const kelasPerjalanan = document.getElementById('kelasPerjalanan');
        
        if (customerName) customerName.value = '';
        if (origin) origin.value = '';
        if (destination) destination.value = '';
        if (passengers) passengers.value = '1';
        if (travelDate) travelDate.value = '';
        if (additionalMessage) additionalMessage.value = '';
        if (kelasPerjalanan) kelasPerjalanan.value = '';
        
        // Update Kelas Perjalanan options berdasarkan tipe
        this.updateKelasOptions(type);
        
        // Show modal with animation
        modal.style.display = 'flex';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        console.log('✅ Modal opened and visible');
    },
    
    // Update Kelas Perjalanan dropdown sesuai tipe transportasi
    updateKelasOptions(type = null) {
        const selectElement = document.getElementById('kelasPerjalanan');
        if (!selectElement) return;
        
        // Gunakan type dari parameter atau ambil dari hidden field
        const selectedType = type || document.getElementById('selectedType').value;
        
        // Get kelas options untuk type yang dipilih
        const kelasOptions = this.kelasPerjalananData[selectedType] || [];
        
        // Clear existing options except default
        selectElement.innerHTML = '<option value="">Pilih Kelas</option>';
        
        // Add kelas options
        kelasOptions.forEach(kelas => {
            const option = document.createElement('option');
            option.value = kelas.value;
            option.textContent = kelas.label;
            selectElement.appendChild(option);
        });
        
        console.log(`✅ Kelas options updated for: ${selectedType}`, kelasOptions);
    },
    
    // tutup modal
    closeModal() {
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300); // Wait for animation to finish
            document.body.style.overflow = '';
        }
        console.log('✖️ Modal closed');
    },
    
    // proses form booking
    submitForm(event) {
        event.preventDefault();
        
        const formData = {
            service: document.getElementById('selectedService').value,
            type: document.getElementById('selectedType').value,
            name: document.getElementById('customerName').value,
            origin: document.getElementById('origin').value,
            destination: document.getElementById('destination').value,
            passengers: document.getElementById('passengers').value || '1',
            date: document.getElementById('travelDate').value || '',
            kelas: document.getElementById('kelasPerjalanan').value || '',
            message: document.getElementById('additionalMessage').value || ''
        };
        
        // Validate required fields
        if (!formData.name || !formData.origin || !formData.destination || !formData.kelas) {
            alert('Mohon lengkapi semua field yang wajib diisi (*)');
            return;
        }
        
        // Generate WhatsApp message
        const waMessage = this.generateWhatsAppMessage(formData);
        
        // Get company WhatsApp number
        const waNumber = (window.COMPANY_WHATSAPP || '6285821841529').replace(/\D/g, '');
        
        // Open WhatsApp
        const waURL = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMessage)}`;
        window.open(waURL, '_blank');
        
        // Close modal
        this.closeModal();
        
        console.log('📱 Booking sent via WhatsApp');
    },
    
    // buat pesan whatsapp
    generateWhatsAppMessage(formData) {
        let message = `*PEMESANAN TIKET - CV. CENDANA TRAVEL*\n\n`;
        message += `Halo Admin, saya ingin melakukan pemesanan:\n\n`;
        message += `*Jenis Layanan:* ${formData.service}\n`;
        message += `*Nama:* ${formData.name}\n`;
        message += `*Asal:* ${formData.origin}\n`;
        message += `*Tujuan:* ${formData.destination}\n`;
        message += `*Kelas Perjalanan:* ${formData.kelas}\n`;
        message += `*Jumlah Penumpang:* ${formData.passengers} orang\n`;
        
        if (formData.date) {
            try {
                const dateObj = new Date(formData.date);
                const dateStr = dateObj.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                message += `*Tanggal Berangkat:* ${dateStr}\n`;
            } catch (e) {
                message += `*Tanggal Berangkat:* ${formData.date}\n`;
            }
        }
        
        if (formData.message) {
            message += `\n*Pesan Tambahan:*\n${formData.message}\n`;
        }
        
        message += '\n_Mohon informasi ketersediaan dan harga._\n\n';
        message += 'Terima kasih! 🙏';
        
        return message;
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('🌟 DOM Content Loaded - Starting Booking App');
    console.log('Available DATA_TRANSPORTASI_DEFAULT:', typeof DATA_TRANSPORTASI_DEFAULT);
    
    // Check if modal exists
    const modal = document.getElementById('bookingModal');
    if (modal) {
        console.log('✅ Modal #bookingModal exists in DOM');
    } else {
        console.error('❌ Modal #bookingModal NOT found in DOM');
        console.log('All IDs in page:', Array.from(document.querySelectorAll('[id]')).map(el => el.id));
    }
    
    bookingApp.init();
});

// Export for compatibility
window.bookingApp = bookingApp;
console.log('📜 pemesanan.js loaded, bookingApp exported to window');
console.log('bookingApp.openModal function available:', typeof window.bookingApp.openModal);

// Quick test: log when script loads
console.log('✅ pemesanan.js fully loaded and ready');
