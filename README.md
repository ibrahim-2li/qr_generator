# QR Generator - Dynamic QR Code Platform

A comprehensive Laravel-based QR code generation platform that allows users to create, manage, and track dynamic QR codes with social media integration and subscription-based features.

## 🚀 Features

### Core Functionality

-   **Dynamic QR Code Generation**: Create customizable QR codes with various content types
-   **Social Media Integration**: Link to multiple social platforms (LinkedIn, Snapchat, X/Twitter, Facebook, Instagram, YouTube)
-   **Profile Management**: Upload profile photos and manage contact information
-   **Scan Tracking**: Monitor QR code scans with detailed analytics including device type, OS, and location
-   **Responsive Design**: Modern, mobile-friendly interface built with Tailwind CSS

### Subscription System

-   **Multiple Plans**: Flexible subscription options with different features
-   **Payment Processing**: Integrated payment system for subscription management
-   **User Dashboard**: Comprehensive admin panel built with Filament
-   **Trial System**: Free trial functionality for new users

### Analytics & Tracking

-   **Scan Analytics**: Track QR code performance with detailed metrics
-   **Device Detection**: Identify device types and operating systems
-   **Geographic Tracking**: Monitor scan locations (IP-based)
-   **Real-time Dashboard**: Live analytics and reporting

## 🛠️ Technology Stack

-   **Backend**: Laravel 12.32.5
-   **Frontend**: Tailwind CSS 4.1.14, Livewire 3.6.4
-   **Admin Panel**: Filament 4.0.0
-   **Database**: MySQL
-   **PHP Version**: 8.4.12
-   **Testing**: Pest 4.1.1, PHPUnit 12.3.15

## 📋 Requirements

-   PHP 8.4+
-   Composer
-   Node.js & NPM
-   MySQL 5.7+ or MariaDB 10.2+
-   Laravel Sail (recommended for development)

## 🚀 Installation

### Using Laravel Sail (Recommended)

1. **Clone the repository**

    ```bash
    git clone https://github.com/yourusername/qr_generator.git
    cd qr_generator
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Setup environment**

    ```bash
    cp .env.example .env
    ```

4. **Start the development environment**

    ```bash
    ./vendor/bin/sail up -d
    ```

5. **Generate application key**

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6. **Run migrations**

    ```bash
    ./vendor/bin/sail artisan migrate
    ```

7. **Install frontend dependencies and build assets**

    ```bash
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run build
    ```

8. **Create storage link**
    ```bash
    ./vendor/bin/sail artisan storage:link
    ```

### Manual Installation

1. **Clone and install dependencies**

    ```bash
    git clone https://github.com/yourusername/qr_generator.git
    cd qr_generator
    composer install
    npm install
    ```

2. **Configure environment**

    ```bash
    cp .env.example .env
    # Edit .env with your database and mail settings
    ```

3. **Setup database**

    ```bash
    php artisan migrate
    php artisan storage:link
    ```

4. **Build assets**

    ```bash
    npm run build
    ```

5. **Start the application**
    ```bash
    php artisan serve
    ```

## 📖 Usage

### Creating QR Codes

1. **Register/Login**: Create an account or sign in to your existing account
2. **Subscribe**: Choose a subscription plan to access QR code creation features
3. **Create QR Code**: Use the dashboard to create new QR codes with:
    - Profile information (name, email, phone, company)
    - Social media links
    - Profile photo upload
    - Custom colors and styling

### Managing QR Codes

-   **Dashboard**: Access your QR codes through the Filament admin panel
-   **Analytics**: Monitor scan statistics and performance metrics
-   **Customization**: Update QR code content and styling anytime
-   **Sharing**: Get shareable links for your QR codes

### QR Code Display

When users scan your QR codes, they'll see a beautiful landing page with:

-   Your profile photo and information
-   Clickable social media buttons
-   Professional contact details
-   Responsive design for all devices

## 🗄️ Database Schema

### Core Models

-   **Users**: User accounts and authentication
-   **QrCodes**: QR code records with metadata
-   **QrContents**: Detailed content for each QR code
-   **Scans**: Analytics data for each scan
-   **Plans**: Subscription plan definitions
-   **Subscriptions**: User subscription records
-   **Payments**: Payment transaction history

### Key Relationships

```
User -> QrCodes -> QrContents
User -> Subscriptions -> Plan
QrCode -> Scans
```

## 🔧 Configuration

### Environment Variables

Key environment variables to configure:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qr_generator
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=

# Payment gateway configuration
STRIPE_KEY=
STRIPE_SECRET=
```

## 🧪 Testing

Run the test suite using Pest:

```bash
./vendor/bin/sail test
# or
php artisan test
```

## 📁 Project Structure

```
app/
├── Filament/           # Admin panel resources
├── Http/Controllers/   # Application controllers
├── Models/            # Eloquent models
└── Providers/         # Service providers

resources/
├── views/             # Blade templates
│   └── qr/           # QR code display pages
└── css/              # Stylesheets

database/
├── migrations/        # Database migrations
└── seeders/          # Database seeders
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/ibrahim-2li/qr_generator/issues) page
2. Create a new issue with detailed information
3. Contact support at [ibrahim.2li@hotmail.com]

## 🎯 Roadmap

-   [ ] Advanced analytics dashboard
-   [ ] QR code templates and themes
-   [ ] Bulk QR code generation
-   [ ] API endpoints for third-party integration
-   [ ] Mobile app integration
-   [ ] Advanced customization options

---

**Built with ❤️ using Laravel and Filament**
