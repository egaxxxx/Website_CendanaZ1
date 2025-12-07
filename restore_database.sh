#!/bin/bash
# =====================================================
# Script Restore Database CV. Cendana Travel
# =====================================================
# Dibuat: 6 Desember 2025
# Fungsi: Restore database dari file backup
# =====================================================

# Konfigurasi Database
DB_USER="root"
DB_PASS="Hananta123"
DB_NAME="cendana_travel"

# Direktori backup
BACKUP_DIR="/srv/http/Website-Cendana/backups"

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  RESTORE DATABASE CV. CENDANA TRAVEL${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Cek apakah ada backup
if [ ! -d "$BACKUP_DIR" ] || [ -z "$(ls -A $BACKUP_DIR/${DB_NAME}_backup_*.sql.gz 2>/dev/null)" ]; then
    echo -e "${RED}❌ Tidak ada file backup ditemukan!${NC}"
    echo -e "${YELLOW}   Direktori: $BACKUP_DIR${NC}"
    echo ""
    exit 1
fi

# Tampilkan daftar backup yang tersedia
echo -e "${YELLOW}📋 Daftar Backup Tersedia:${NC}"
echo ""

backups=($(ls -t "$BACKUP_DIR"/${DB_NAME}_backup_*.sql.gz 2>/dev/null))
count=1

for backup in "${backups[@]}"; do
    filename=$(basename "$backup")
    filesize=$(du -h "$backup" | cut -f1)
    filedate=$(stat -c %y "$backup" | cut -d'.' -f1)
    echo -e "   ${GREEN}[$count]${NC} $filename"
    echo -e "       Size: $filesize | Date: $filedate"
    echo ""
    ((count++))
done

# Minta input user
echo -e "${YELLOW}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
read -p "Pilih nomor backup yang akan di-restore [1-${#backups[@]}]: " choice
echo ""

# Validasi input
if ! [[ "$choice" =~ ^[0-9]+$ ]] || [ "$choice" -lt 1 ] || [ "$choice" -gt "${#backups[@]}" ]; then
    echo -e "${RED}❌ Pilihan tidak valid!${NC}"
    echo ""
    exit 1
fi

# Ambil file backup yang dipilih
SELECTED_BACKUP="${backups[$((choice-1))]}"
SELECTED_NAME=$(basename "$SELECTED_BACKUP")

echo -e "${YELLOW}📄 File yang dipilih: ${GREEN}$SELECTED_NAME${NC}"
echo ""

# Konfirmasi restore
echo -e "${RED}⚠️  PERINGATAN:${NC}"
echo -e "${RED}   Database '$DB_NAME' yang ada akan DIHAPUS dan diganti!${NC}"
echo -e "${RED}   Pastikan Anda sudah backup database saat ini jika diperlukan.${NC}"
echo ""
read -p "Lanjutkan restore? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo -e "${YELLOW}❌ Restore dibatalkan oleh user.${NC}"
    echo ""
    exit 0
fi

echo ""
echo -e "${YELLOW}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${YELLOW}💾 Memulai proses restore...${NC}"
echo -e "${YELLOW}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Backup database saat ini (sebagai safety)
SAFETY_BACKUP="$BACKUP_DIR/${DB_NAME}_before_restore_$(date +%Y%m%d_%H%M%S).sql.gz"
echo -e "${YELLOW}🔒 Membuat safety backup database saat ini...${NC}"
mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" 2>/dev/null | gzip > "$SAFETY_BACKUP"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}   ✅ Safety backup berhasil: $(basename $SAFETY_BACKUP)${NC}"
else
    echo -e "${YELLOW}   ⚠️  Safety backup gagal (database mungkin belum ada)${NC}"
fi
echo ""

# Drop database lama
echo -e "${YELLOW}🗑️  Menghapus database lama...${NC}"
mysql -u "$DB_USER" -p"$DB_PASS" -e "DROP DATABASE IF EXISTS $DB_NAME;" 2>/dev/null

# Buat database baru
echo -e "${YELLOW}📝 Membuat database baru...${NC}"
mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null

# Restore dari backup
echo -e "${YELLOW}📥 Me-restore database dari backup...${NC}"
gunzip -c "$SELECTED_BACKUP" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" 2>/dev/null

# Cek apakah restore berhasil
if [ $? -eq 0 ]; then
    echo ""
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}✅ RESTORE BERHASIL!${NC}"
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "📄 File: ${GREEN}$SELECTED_NAME${NC}"
    echo -e "📅 Date: ${GREEN}$(date '+%d %B %Y %H:%M:%S')${NC}"
    echo -e "🔒 Safety backup: ${GREEN}$(basename $SAFETY_BACKUP)${NC}"
    echo ""
    
    # Tampilkan jumlah tabel
    TABLE_COUNT=$(mysql -u "$DB_USER" -p"$DB_PASS" -Nse "USE $DB_NAME; SHOW TABLES;" 2>/dev/null | wc -l)
    echo -e "📊 Jumlah tabel: ${GREEN}$TABLE_COUNT${NC}"
    echo ""
    
else
    echo ""
    echo -e "${RED}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${RED}❌ RESTORE GAGAL!${NC}"
    echo -e "${RED}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    
    # Coba restore safety backup
    if [ -f "$SAFETY_BACKUP" ]; then
        echo -e "${YELLOW}🔄 Mencoba restore dari safety backup...${NC}"
        mysql -u "$DB_USER" -p"$DB_PASS" -e "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
        gunzip -c "$SAFETY_BACKUP" | mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" 2>/dev/null
        
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✅ Database berhasil dikembalikan ke kondisi sebelumnya${NC}"
        fi
    fi
    
    echo ""
    exit 1
fi

echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${GREEN}   RESTORE SELESAI${NC}"
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
