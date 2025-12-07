#!/bin/bash
# =====================================================
# Script Backup Database CV. Cendana Travel
# =====================================================
# Dibuat: 6 Desember 2025
# Fungsi: Backup otomatis database dengan timestamp
# =====================================================

# Konfigurasi Database
DB_USER="root"
DB_PASS="Hananta123"
DB_NAME="cendana_travel"

# Direktori backup
BACKUP_DIR="/srv/http/Website-Cendana/backups"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="$BACKUP_DIR/${DB_NAME}_backup_${DATE}.sql"

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${YELLOW}  BACKUP DATABASE CV. CENDANA TRAVEL${NC}"
echo -e "${YELLOW}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Buat direktori backup jika belum ada
if [ ! -d "$BACKUP_DIR" ]; then
    echo -e "${YELLOW}📁 Membuat direktori backup...${NC}"
    mkdir -p "$BACKUP_DIR"
fi

# Lakukan backup
echo -e "${YELLOW}💾 Memulai backup database...${NC}"
echo -e "   Database: ${GREEN}$DB_NAME${NC}"
echo -e "   File: ${GREEN}$BACKUP_FILE${NC}"
echo ""

mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_FILE" 2>/dev/null

# Cek apakah backup berhasil
if [ $? -eq 0 ]; then
    # Kompress file backup
    echo -e "${YELLOW}📦 Mengkompress backup...${NC}"
    gzip "$BACKUP_FILE"
    BACKUP_FILE="${BACKUP_FILE}.gz"
    
    # Hitung ukuran file
    FILESIZE=$(du -h "$BACKUP_FILE" | cut -f1)
    
    echo ""
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}✅ BACKUP BERHASIL!${NC}"
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "📄 File: ${GREEN}$BACKUP_FILE${NC}"
    echo -e "📊 Size: ${GREEN}$FILESIZE${NC}"
    echo -e "📅 Date: ${GREEN}$(date '+%d %B %Y %H:%M:%S')${NC}"
    echo ""
    
    # Hapus backup lama (lebih dari 30 hari)
    echo -e "${YELLOW}🗑️  Membersihkan backup lama (>30 hari)...${NC}"
    find "$BACKUP_DIR" -name "${DB_NAME}_backup_*.sql.gz" -mtime +30 -delete
    
    # Tampilkan jumlah backup yang tersimpan
    BACKUP_COUNT=$(ls -1 "$BACKUP_DIR"/${DB_NAME}_backup_*.sql.gz 2>/dev/null | wc -l)
    echo -e "   Total backup tersimpan: ${GREEN}$BACKUP_COUNT file${NC}"
    echo ""
    
else
    echo ""
    echo -e "${RED}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${RED}❌ BACKUP GAGAL!${NC}"
    echo -e "${RED}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${RED}Periksa kredensial database atau koneksi MySQL${NC}"
    echo ""
    exit 1
fi

# Tampilkan daftar 5 backup terbaru
echo -e "${YELLOW}📋 5 Backup Terbaru:${NC}"
ls -lht "$BACKUP_DIR"/${DB_NAME}_backup_*.sql.gz 2>/dev/null | head -5 | awk '{printf "   %s %s %s - %s\n", $6, $7, $8, $9}'
echo ""

echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${GREEN}   BACKUP SELESAI${NC}"
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
