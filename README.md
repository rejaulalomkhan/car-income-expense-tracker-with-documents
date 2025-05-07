# Car Expense Tracker

A modern, business-friendly Laravel application to track car-related income and expenses, generate insightful reports, and manage your fleet efficiently.

---

## 🚗 Project Overview
Car Expense Tracker helps you record, analyze, and report all financial activities related to your vehicles. It supports custom branding, advanced filtering, and professional PDF report exports.

---

## ✨ Features
- Car management (add, edit, delete cars)
- Record income and expenses for each car
- Advanced reporting with filters:
  - By car
  - By date range (This Month, Last Month, This Year, Custom)
  - By type (Income, Expense, All)
- Summary cards (Total Income, Total Expense, Net Balance)
- Grouping by car and by category
- Export reports as PDF (with logo, title, period, and summary)
- Custom branding (logo, favicon, PWA icon)
- Bengali language support
- Responsive, modern UI/UX

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm (for frontend assets)
- MySQL or compatible database

### Installation
1. **Clone the repository:**
   ```bash
   git clone https://github.com/rejaulalomkhan/car-expense-tracker.git
   cd car-expense-tracker
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```
3. **Copy and configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env and set your DB credentials, APP_URL, etc.
   ```
4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations:**
   ```bash
   php artisan migrate
   ```
6. **(Optional) Seed demo data:**
   ```bash
   php artisan db:seed
   ```
7. **Start the development server:**
   ```bash
   php artisan serve
   ```

---

## 📝 Usage
- **Login/Register:** Access the app and set up your profile.
- **Add Cars:** Go to the Cars section and add your vehicles.
- **Record Transactions:** Add income or expense entries for each car.
- **View Reports:**
  - Go to the Reports page.
  - Filter by car, date range, and type.
  - View summary and detailed breakdowns.
  - Export as PDF for sharing or printing.

---

## 📊 Reporting
- **Filters:**
  - Car: Select a specific car or all cars.
  - Date Range: This Month, Last Month, This Year, or custom range.
  - Type: Income, Expense, or All Types.
- **Summary:**
  - Total Income, Total Expense, Net Balance.
- **Breakdown:**
  - Income by Car, Expense by Car, Expense by Category.
- **PDF Export:**
  - Includes logo, app name, period, and all summary data.
  - Layout matches the on-screen report.

---

## 🎨 Customization
- **Branding:** Upload your own logo from the settings page.
- **PWA Support:** Add to home screen for a native app feel.
- **Language:** Bengali and English supported.

---

## 🌏 Timezone
- The application uses `Asia/Dhaka` timezone by default for all reports and timestamps.

---

## 🛠️ Troubleshooting
- If PDF export layout is broken, ensure you have the required fonts and the `barryvdh/laravel-dompdf` package installed.
- For time issues, check your `.env` and `config/app.php` timezone settings.

---

## 🤝 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

---

## 📬 Support
For support, open an issue or contact the maintainer.

---

## 📄 License
[MIT](LICENSE)
