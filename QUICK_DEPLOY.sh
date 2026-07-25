#!/bin/bash

# Quick Deployment Script untuk Niagahoster
# Run this script setelah clone repository
# Usage: bash QUICK_DEPLOY.sh

set -e

echo "======================================"
echo "Arsip Digital USBR - Quick Deploy"
echo "======================================"
echo ""

# Color codes
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}[1/8] Installing Composer Dependencies...${NC}"
composer install --no-dev --optimize-autoloader
echo -e "${GREEN}✓ Composer dependencies installed${NC}"
echo ""

echo -e "${YELLOW}[2/8] Installing NPM Dependencies...${NC}"
npm install
echo -e "${GREEN}✓ NPM dependencies installed${NC}"
echo ""

echo -e "${YELLOW}[3/8] Building Frontend Assets...${NC}"
npm run build
echo -e "${GREEN}✓ Frontend assets built${NC}"
echo ""

echo -e "${YELLOW}[4/8] Setting up Environment...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    echo -e "${GREEN}✓ .env file created${NC}"
else
    echo -e "${YELLOW}⚠ .env file already exists${NC}"
fi
echo ""

echo -e "${YELLOW}[5/8] Generating Application Key...${NC}"
php artisan key:generate
echo -e "${GREEN}✓ Application key generated${NC}"
echo ""

echo -e "${YELLOW}[6/8] Creating Storage Directories...${NC}"
mkdir -p storage/app/documents
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
echo -e "${GREEN}✓ Storage directories created${NC}"
echo ""

echo -e "${YELLOW}[7/8] Setting Permissions...${NC}"
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
chmod 755 public
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

echo -e "${YELLOW}[8/8] Optimizing for Production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Production optimization complete${NC}"
echo ""

echo "======================================"
echo -e "${GREEN}✓ Deployment Preparation Complete!${NC}"
echo "======================================"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Edit .env file dengan database credentials"
echo "2. Run: php artisan migrate --force"
echo "3. Run: php artisan db:seed"
echo "4. Run: php artisan storage:link"
echo "5. Setup SSL di cPanel"
echo ""
echo "Default Credentials:"
echo "Email: admin@usbr.ac.id"
echo "Password: password"
echo ""
echo "For detailed setup, see NIAGAHOSTER_SETUP.md"