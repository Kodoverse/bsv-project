# BSV (Biblioteca) - Library Management System

A comprehensive library management system built with Vue.js frontend and Laravel backend, featuring event management, user roles, points system, and partner marketplace.

## 🚀 Features

### 📚 **Core Library Features**
- **Article Management**: Create, read, update, and delete articles with rich content
- **Comment System**: Users can comment on articles with moderation capabilities
- **User Profiles**: Complete user profile management with personal information
- **Content Sections**: Organized content sections for better navigation

### 🎯 **Event Management System**
- **Event Categories**: Organize events by categories (workshops, conferences, etc.)
- **Event Registration**: Users can register for events with real-time availability
- **Event Timeline**: Visual timeline showing upcoming, ongoing, and past events
- **Volunteer Events**: Special events that award points to participants
- **Image Upload**: Support for event images with proper storage and display
- **Event Status Management**: Track event lifecycle (upcoming, ongoing, finished)

### 👥 **User Role Management**
- **Multi-Role System**: Users, Editors, Admins, Librarians, and Partners
- **Role-Based Access Control**: Different permissions for different user types
- **Admin Dashboard**: Comprehensive admin panel for system management
- **Partner Dashboard**: Specialized interface for business partners

### 🏆 **Points & Rewards System**
- **Volunteer Points**: Earn points by participating in volunteer events
- **Points Tracking**: Complete transaction history and balance management
- **Redemption System**: Use points to purchase items from partner businesses
- **Admin Point Management**: Admins can award and manage user points

### 🛒 **Partner Marketplace**
- **Business Profiles**: Partners can create detailed business profiles
- **Product Management**: Partners can add, edit, and manage their products
- **Point-Based Purchases**: Users can buy products using earned points
- **Redemption Codes**: Secure code-based redemption system
- **Sales Analytics**: Partners can track their sales and performance
- **Business Categories**: Organize businesses by type (cafe, restaurant, etc.)

### 📊 **Admin Dashboard Features**
- **User Management**: View, edit, and manage user accounts and roles
- **Event Management**: Create, edit, and manage events and categories
- **Attendance Management**: Track and confirm volunteer event attendance
- **Partner Management**: Manage partner accounts and business information
- **Registration Management**: View and manage event registrations
- **Analytics**: Dashboard with key metrics and statistics

### 🎨 **Modern UI/UX**
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Dark Theme**: Modern dark theme with gradient accents
- **Interactive Components**: Smooth animations and hover effects
- **Accessibility**: Built with accessibility best practices

## 🛠️ Technology Stack

### **Frontend**
- **Vue.js 3.5.13**: Progressive JavaScript framework
- **Vue Router 4.5.0**: Client-side routing
- **Tailwind CSS 4.1.13**: Utility-first CSS framework
- **Axios 1.8.4**: HTTP client for API requests
- **Vite 6.2.0**: Fast build tool and development server
- **Flowbite 3.1.2**: UI component library
- **Swiper 11.2.6**: Touch slider component
- **Date-fns 4.1.0**: Date manipulation library

### **Backend**
- **Laravel 11.31**: PHP web framework
- **Laravel Sanctum 4.0**: API authentication
- **PHP 8.2+**: Server-side programming language
- **MySQL**: Primary database
- **Eloquent ORM**: Database abstraction layer

### **Development Tools**
- **Composer**: PHP dependency manager
- **NPM**: Node.js package manager
- **Laravel Pint**: Code style fixer
- **PHPUnit**: Testing framework
- **Laravel Pail**: Log viewer

## 📁 Project Structure

```
bsv-project/
├── frontend/                 # Vue.js frontend application
│   ├── src/
│   │   ├── components/      # Reusable Vue components
│   │   │   ├── admin/       # Admin-specific components
│   │   │   └── partner/     # Partner-specific components
│   │   ├── pages/           # Page components
│   │   ├── router.js        # Vue Router configuration
│   │   ├── store.js         # Global state management
│   │   └── style.css        # Global styles
│   ├── public/              # Static assets
│   └── package.json         # Frontend dependencies
├── backend/                 # Laravel backend application
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   └── Api/     # API controllers
│   │   │   └── Middleware/  # Custom middleware
│   │   └── Models/          # Eloquent models
│   ├── database/
│   │   ├── migrations/      # Database migrations
│   │   └── seeders/         # Database seeders
│   ├── routes/
│   │   └── api.php          # API routes
│   └── composer.json        # Backend dependencies
└── README.md               # This file
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and NPM
- MySQL 8.0+
- Git

### Backend Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd bsv-project/backend
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` with your database credentials
   - Create a MySQL database for the application

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the Laravel server**
   ```bash
   php artisan serve
   ```

### Frontend Setup

1. **Navigate to frontend directory**
   ```bash
   cd ../frontend
   ```

2. **Install Node.js dependencies**
   ```bash
   npm install
   ```

3. **Start the development server**
   ```bash
   npm run dev
   ```

4. **Build for production**
   ```bash
   npm run build
   ```

## 🔧 Configuration

### Environment Variables

#### Backend (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bsv_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173
```

#### Frontend (vite.config.js)
```javascript
export default defineConfig({
  plugins: [vue()],
  server: {
    host: 'localhost',
    port: 5173,
    proxy: {
      '/api': 'http://localhost:8000'
    }
  }
})
```

## 📊 Database Schema

### Core Models

#### Users
- **id**: Primary key
- **email**: Unique email address
- **password**: Hashed password
- **user_role**: Enum (user, editor, admin, librarian, partner)
- **email_verified_at**: Email verification timestamp

#### Events
- **id**: Primary key
- **category_id**: Foreign key to event_categories
- **created_by**: Foreign key to users
- **title**: Event title
- **description**: Event description
- **image_url**: Event image path
- **starts_at**: Event start datetime
- **ends_at**: Event end datetime
- **status**: Event status (upcoming, ongoing, finished)
- **is_volunteer_event**: Boolean flag for volunteer events
- **volunteer_points**: Points awarded for participation
- **max_participants**: Maximum number of participants

#### Points
- **id**: Primary key
- **user_id**: Foreign key to users
- **event_id**: Foreign key to events (nullable)
- **awarded_by**: Foreign key to users (admin who awarded)
- **points**: Point amount (positive for awards, negative for redemptions)
- **reason**: Reason for point transaction
- **type**: Transaction type (award, redemption)
- **partner_id**: Foreign key to users (for redemptions)
- **redemption_reference**: Reference for redemption transactions

#### Products
- **id**: Primary key
- **partner_id**: Foreign key to users
- **name**: Product name
- **description**: Product description
- **image_url**: Product image path
- **points_price**: Price in points
- **cash_equivalent**: Cash value equivalent
- **stock_quantity**: Available quantity (-1 for unlimited)
- **category**: Product category
- **is_available**: Availability status

## 🔐 Authentication & Authorization

### User Roles

1. **User**: Basic user with limited permissions
   - View articles and events
   - Register for events
   - Comment on articles
   - Purchase products with points

2. **Editor**: Content management permissions
   - All user permissions
   - Create and edit articles
   - Moderate comments

3. **Admin**: Full system access
   - All editor permissions
   - Manage users and roles
   - Manage events and categories
   - Award and manage points
   - Access admin dashboard

4. **Librarian**: Library-specific permissions
   - Manage library content
   - Moderate user content

5. **Partner**: Business partner permissions
   - Manage business profile
   - Manage products
   - Process redemptions
   - View sales analytics

### API Authentication
- **Laravel Sanctum**: Stateful API authentication
- **CSRF Protection**: Cross-site request forgery protection
- **Middleware**: Role-based access control

## 🎯 Key Features Explained

### Event Registration System
1. **Browse Events**: Users can view events by category
2. **Event Details**: Detailed event information with images
3. **Registration**: One-click registration with real-time availability
4. **Cancellation**: Users can cancel their registration
5. **Volunteer Events**: Special events that award points

### Points System
1. **Earning Points**: Participate in volunteer events
2. **Point Tracking**: Complete transaction history
3. **Redemption**: Use points to purchase partner products
4. **Admin Management**: Admins can award/manage points

### Partner Marketplace
1. **Business Profiles**: Partners create detailed business information
2. **Product Catalog**: Partners manage their product offerings
3. **Point Purchases**: Users buy products using earned points
4. **Redemption Process**: Secure code-based redemption system

### Admin Dashboard
1. **User Management**: View and manage all users
2. **Event Management**: Create and manage events
3. **Attendance Tracking**: Confirm volunteer event attendance
4. **Partner Management**: Manage partner accounts
5. **Analytics**: System-wide statistics and metrics

## 🚀 API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `POST /api/register` - User registration
- `GET /api/user` - Get current user

### Events
- `GET /api/events` - List events
- `POST /api/events` - Create event (admin)
- `PUT /api/events/{id}` - Update event (admin)
- `DELETE /api/events/{id}` - Delete event (admin)
- `POST /api/event-registrations` - Register for event
- `POST /api/event-registrations/{id}/cancel` - Cancel registration

### Points
- `GET /api/points/my` - Get user's points
- `POST /api/points/award` - Award points (admin)
- `POST /api/points/redeem` - Redeem points

### Products
- `GET /api/products` - List products
- `POST /api/products` - Create product (partner)
- `PUT /api/products/{id}` - Update product (partner)
- `DELETE /api/products/{id}` - Delete product (partner)

### Purchases
- `GET /api/purchases` - List user purchases
- `POST /api/purchases` - Create purchase
- `POST /api/purchases/verify` - Verify redemption code (partner)
- `POST /api/purchases/{id}/confirm` - Confirm purchase (partner)

## 🧪 Testing

### Backend Testing
```bash
cd backend
php artisan test
```

### Frontend Testing
```bash
cd frontend
npm run test
```

## 📝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request


## 🔄 Version History

- **v1.0.0** - Initial release with core library features
- **v1.1.0** - Added event management system
- **v1.2.0** - Implemented points and rewards system
- **v1.3.0** - Added partner marketplace
- **v1.4.0** - Enhanced admin dashboard and user management

---

**Built with ❤️ for the BSV Library Community**
