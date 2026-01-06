# 📦 PHP Orders Summary

A lightweight PHP project that processes order data from CSV files and generates a JSON summary. Designed for backend portfolio demonstration and easy API integration.

## 🛠️ Tech Stack
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![OpenAPI](https://img.shields.io/badge/OpenAPI-6BA539?style=for-the-badge&logo=openapi-initiative&logoColor=white)
![PowerShell](https://img.shields.io/badge/PowerShell-5391FE?style=for-the-badge&logo=powershell&logoColor=white)

## 🚀 Features
- **CSV to JSON:** Efficiently converts `orders_data.csv` into structured JSON summaries.
- **API Documentation:** Fully documented via `openapi.yaml`.
- **Easy Execution:** Includes automation scripts for Swagger UI.
- **Clean Logic:** Modular PHP approach using `main.php` and `orders.php`.

## 📂 Project Structure
```text
.
├── docs/                 # Documentation assets
├── main.php              # Application entry point
├── orders.php            # Core order processing logic
├── openapi.yaml          # API specification
├── orders_data.csv       # Sample input data
├── orders_summary.json   # Generated output summary
├── README.md             # Project documentation
└── run-swagger.ps1       # PowerShell script to launch Swagger
```

## ⚡ Getting Started

### 1. Clone the repo
```bash
git clone [https://github.com/karxoo/php-orders-summary.git](https://github.com/karxoo/php-orders-summary.git)
cd php-orders-summary
```

### 2. Install Dependencies
Note: This project uses native PHP functions. If you add PHPUnit or other libraries later, run:

```bash
composer install
```

### 3. Run Locally (API Mode)
To view the API documentation using Swagger (Windows):
```bash
./run-swagger.ps1
```

### 4. CLI Usage
Run the processor manually via the command line:

```bash
php main.php
```

## 🔍 Example Output
- Input: orders_data.csv
- Generated: orders_summary.json
```json
{
  "total_revenue": 710,
  "best_selling_sku": {
    "sku": "SKU-A123",
    "total_quantity": 5
  }
}
```

## 🎯 Roadmap
```text
[ ] Add unit tests for orders.php
[ ] Implement multi-currency support
[ ] Add a web-based dashboard for the summary
[ ] Containerize with Docker
```

## 🤝 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you’d like to change.
