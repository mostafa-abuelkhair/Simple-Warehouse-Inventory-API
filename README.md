# Warehouse Inventory API

A simplified RESTful API for managing inventory across multiple warehouses

## Features
- **Auth**: Secured with Laravel Sanctum.
- **Inventory**: Paginated listing with search/price filters.
- **Warehouses**: Management and cached inventory views.
- **Stocks**: Unified stock updates with low-stock alerts (Observer pattern).
- **Transfers**: Pessimistic locking for race-safe stock transfers.

---

## Setup Options

### 1. Docker (Recommended)
```bash
# Clone and enter directory
git clone https://github.com/mostafa-abuelkhair/Simple-Warehouse-Inventory-API.git
cd warehouse-inventory-api


# Start containers
cp docker/env.docker .env
docker compose up -d --build

# Initialize app
docker exec warehouse-inventory-api-app composer install
docker exec warehouse-inventory-api-app php artisan migrate --seed
docker exec warehouse-inventory-api-app php artisan key:generate
```
Access at: `http://localhost:8080`

### 2. Local PHP Artisan
```bash
composer install
cp .env.example .env # Configure your DB/Redis
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## API Documentation

All routes except Auth require `Authorization: Bearer <token>`.

### Authentication
| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/register` | Register new user |
| POST | `/api/login` | Get bearer token |
| POST | `/api/logout` | Revoke token |

### Inventory & Warehouses
| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/inventory` | List items (filters: `name`, `min_price`, `max_price`, `warehouse_id`) |
| GET | `/api/inventory/{id}` | Get item details |
| GET | `/api/warehouses` | List all warehouses |
| GET | `/api/warehouses/{id}/inventory` | Get cached stock levels for a warehouse |

### Stock Operations
| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/stocks` | Create or update stock level |
| POST | `/api/stock-transfers` | Transfer stock between warehouses |
| GET | `/api/stock-transfers` | List transfer history |

---

## Testing
```bash
# Docker
docker exec warehouse-inventory-api-app php artisan test

# Local
php artisan test
```
