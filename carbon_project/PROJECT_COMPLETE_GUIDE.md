#  - Complete Project Guide

## Table of Contents
1. Project Overview
2. Technology Stack
3. ArchitectureCarbon Footprint Tracker
4. User Roles & Features
5. Database Structure
6. Backend Implementation
7. Frontend Implementation
8. Machine Learning Integration
9. User Flow & Workflows
10. Installation & Setup
11. API Endpoints
12. How Everything Works Together

---

## 1. PROJECT OVERVIEW

### What is This Project?

The **Carbon Footprint Tracker** is a modern web application designed to help users monitor and reduce their environmental impact by tracking their daily carbon emissions. It's built as an MCA (Masters in Computer Applications) project that combines web development, machine learning, and data visualization into a single cohesive platform.

The core purpose is to enable users to log their daily activities (travel, electricity usage, food consumption, and water usage), automatically calculate their carbon footprint, classify their environmental impact, and receive personalized recommendations to become more sustainable. The system uses both rule-based classification and machine learning models to predict impact levels accurately.

### Key Business Goals

- **Track Emissions**: Users can log multiple carbon-producing activities daily
- **Educate Users**: Display impact classifications to raise awareness about environmental damage
- **Predict Impact**: Use AI to predict carbon impact based on user behavior patterns
- **Provide Recommendations**: Give actionable advice to reduce carbon footprint
- **Export Data**: Allow users to export their carbon history for personal record-keeping
- **Visualize Trends**: Show charts and analytics of emission patterns over time

---

## 2. TECHNOLOGY STACK

### Backend Technologies

**Laravel 12.0** - The web framework handling all server-side logic, routing, authentication, and database operations. Laravel provides:
- Eloquent ORM for database interactions
- Blade templating engine for HTML rendering
- Built-in authentication system (Laravel Breeze)
- Migration system for database version control
- Form validation using Request classes
- Middleware for request filtering

**PHP 8.2** - The programming language running on the server. PHP 8.2 provides modern features like named arguments, match expressions, and improved performance.

**SQLite** - The database system storing all user and footprint data. It's lightweight, serverless, and perfect for development/small-scale projects.

### Frontend Technologies

**Bootstrap 5.3** - CSS framework providing responsive design and pre-built components. Used for:
- Grid system (12-column layout)
- Cards, tables, and forms
- Button styles and utilities
- Responsive breakpoints for mobile/tablet/desktop

**Chart.js** - JavaScript library for creating interactive charts. Used for:
- Line charts showing CO2 trends over time
- Pie charts displaying impact distribution
- Bar charts showing emissions by category (Travel, Electricity, Food, Water)

**Tailwind CSS** - Utility-first CSS framework for custom styling and rapid UI development. Configured in `tailwind.config.js`.

**Alpine.js** - Lightweight JavaScript framework for adding interactivity without full framework complexity.

**Vite** - Frontend build tool bundling JavaScript and CSS for optimization. Replaces webpack for faster development.

### Machine Learning Technologies

**Python 3.8+** - Programming language for ML model training and serving.

**Flask** - Lightweight Python web framework creating a REST API that serves ML predictions. The ML service runs on port 5000.

**scikit-learn** - Machine learning library providing the Random Forest classifier algorithm.

**Pandas & NumPy** - Data manipulation and numerical computing libraries for dataset processing.

**Joblib** - Serialization library saving/loading the trained ML model (`model.pkl`).

---

## 3. ARCHITECTURE

### High-Level System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    User Browser                              │
│  (Chrome, Firefox, Safari, etc.)                             │
└──────────────────────┬──────────────────────────────────────┘
                       │ HTTP/HTTPS
                       ▼
┌──────────────────────────────────────────────────────────────┐
│              Laravel Web Server (Port 8000)                   │
│  ┌─────────────────────────────────────────────────────────┐ │
│  │ Route Handler (web.php)                                 │ │
│  │ Determines which controller to use                       │ │
│  └──────────────────┬──────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼──────────────────────────────────────┐ │
│  │ Middleware (Authentication, Session)                   │ │
│  │ Checks if user is logged in                            │ │
│  └──────────────────┬──────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼──────────────────────────────────────┐ │
│  │ Controller (FootprintController)                       │ │
│  │ Handles business logic and calculations                │ │
│  └──────────────────┬──────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼──────────────────────────────────────┐ │
│  │ Model (Footprint, User)                                │ │
│  │ Database abstraction layer                             │ │
│  └──────────────────┬──────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼──────────────────────────────────────┐ │
│  │ Request to ML Service (if configured)                  │ │
│  │ POST /predict with user features                       │ │
│  └──────────────────┬──────────────────────────────────────┘ │
└─────────────────────┼──────────────────────────────────────────┘
                      │ HTTP (Optional)
                      ▼
         ┌────────────────────────────┐
         │  Python Flask ML Service   │
         │  (Port 5000)               │
         │  Random Forest Classifier  │
         │  Returns: Impact Label     │
         └────────────────────────────┘


         ┌────────────────────────────┐
         │  SQLite Database           │
         │  (database/database.sqlite)│
         │  - Users table             │
         │  - Footprints table        │
         │  - Sessions table          │
         └────────────────────────────┘
```

### Request-Response Flow

1. **User submits form** (e.g., Add Footprint page)
2. **Browser sends HTTP POST** to Laravel route `/store`
3. **Middleware checks authentication** - Is user logged in?
4. **Route matches** to `FootprintController@store`
5. **Request validation** - Are inputs valid?
6. **Carbon calculation** - Formula: `(travel_km × 0.21) + (electricity_units × 0.85) + (food_score × 1.5) + (water_usage × 0.05)`
7. **Impact classification** - Rule-based (Low/Medium/High)
8. **ML prediction** - Optional call to Flask service
9. **Recommendation generation** - Rule-based suggestions
10. **Save to database** - Eloquent ORM inserts record
11. **Redirect to dashboard** - Browser goes to `/dashboard`
12. **Dashboard queries data** - Fetch footprints and calculate statistics
13. **Render Blade template** - HTML generated with data
14. **Send HTML to browser** - Browser renders page
15. **Load Chart.js** - JavaScript initializes charts with data

---

## 4. USER ROLES & FEATURES

### Guest (Unauthenticated User)

**What they can see:**
- Landing page with login/register forms
- Project information and sustainability message
- Links to create an account or sign in

**What they can do:**
- View the welcome/landing page
- Register a new account
- Log in with existing credentials

### Authenticated User

**What they can see:**
- Personal dashboard with carbon statistics
- Charts showing emission trends
- Table of all their carbon entries
- Their eco-score and impact level
- Personalized recommendations
- Leaderboard of lowest-emission entries

**What they can do:**
- Add new footprint entries (travel, electricity, food, water)
- Edit existing entries
- Delete entries
- Filter and search entries by date and impact level
- Export footprint data as CSV
- View charts and analytics
- Update their profile
- View AI-generated insights

---

## 5. DATABASE STRUCTURE

### Users Table

```
users
├── id (Primary Key, Auto-increment)
├── name (string)
├── email (string, Unique)
├── password (string, hashed)
├── email_verified_at (datetime, nullable)
├── remember_token (string, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)
```

**Purpose**: Stores user account information for authentication and identification.

### Footprints Table

```
footprints
├── id (Primary Key, Auto-increment)
├── user_id (Foreign Key to users table) [NOT IN CURRENT VERSION]
├── travel_km (decimal 8,2)
│   └─ Distance traveled in kilometers
├── electricity_units (decimal 8,2)
│   └─ Kilowatt-hours consumed
├── food_score (decimal 5,2)
│   └─ Numeric score of meal carbon impact
├── water_usage (decimal 8,2)
│   └─ Liters of water consumed
├── carbon_value (decimal 10,2)
│   └─ Calculated total CO2 in kilograms
├── impact_level (string)
│   └─ Classification: "Low Impact", "Medium Impact", or "High Impact"
├── ml_prediction (string, nullable)
│   └─ Machine learning model prediction (if ML service available)
├── recommendation (text)
│   └─ AI-generated sustainability advice
├── notes (text, nullable)
│   └─ User comments about the entry
├── created_at (timestamp)
└── updated_at (timestamp)
```

**Purpose**: Stores all carbon footprint entries submitted by users. Each row represents one activity/day.

### Migration Timeline

1. `0001_01_01_000000_create_users_table.php` - Creates users table
2. `2026_06_01_000003_create_footprints_table.php` - Creates footprints table
3. `2026_06_01_000004_add_impact_level_to_footprints_table.php` - Adds impact_level column
4. `2026_06_01_000005_add_water_notes_recommendation_to_footprints_table.php` - Adds water, notes, recommendation
5. `2026_06_02_000001_fix_footprint_impact_levels_and_carbon_values.php` - Fixes data
6. `2026_06_02_000002_add_ml_prediction_to_footprints_table.php` - Adds ML prediction

---

## 6. BACKEND IMPLEMENTATION

### Models (Eloquent ORM)

#### User Model (`app/Models/User.php`)

The User model represents a person using the application. It extends Laravel's Authenticatable class to handle login/logout. Key attributes:
- name: The person's full name
- email: Their email address (must be unique)
- password: Hashed password for security

The model uses Laravel Breeze authentication out of the box.

#### Footprint Model (`app/Models/Footprint.php`)

The Footprint model represents a single carbon footprint entry. It's a simple Eloquent model with:
- `$fillable` array: Specifies which fields can be mass-assigned (travel_km, electricity_units, food_score, carbon_value, impact_level, ml_prediction, notes, recommendation)
- `$casts` array: Converts string database values to PHP float types for calculations

Relationships: Currently, the Footprint model doesn't have a belongsTo relationship with User (this is a limitation in the current version - all entries are global rather than user-specific).

### Controllers (Business Logic)

#### FootprintController (`app/Http/Controllers/FootprintController.php`)

This is the main controller handling all carbon footprint operations.

**Key Methods:**

**1. index() - Dashboard View**
- Purpose: Display the dashboard with all footprint data
- Process:
  - Accepts optional filters (date_from, date_to, impact level)
  - Queries the database for all footprints matching filters
  - Groups data by date to calculate daily CO2
  - Calculates statistics (total CO2, average, highest)
  - Calculates impact distribution (Low/Medium/High counts)
  - Calculates category totals (Travel, Electricity, Food, Water)
  - Generates eco-score (0-100 based on average carbon)
  - Identifies top emission source
  - Generates smart insights (AI-like messages)
  - Identifies leaderboard (5 lowest-carbon entries)
  - Returns all data to dashboard.blade.php for rendering

**2. create() - Add Form View**
- Purpose: Show the "Add Footprint" form
- Simply returns the add-footprint.blade.php template

**3. store() - Save New Entry**
- Purpose: Handle form submission and create new footprint
- Process:
  - Validates input using StoreFootprintRequest
  - Calculates carbon value using formula: `(travel_km × 0.21) + (electricity_units × 0.85) + (food_score × 1.5) + (water_usage × 0.05)`
  - Classifies impact (Low/Medium/High) based on thresholds
  - Calls predictMlImpact() to get ML prediction (if service available)
  - Generates recommendation using rule-based engine
  - Creates new Footprint record in database
  - Redirects back to dashboard with success message

**4. edit($id) - Edit Form View**
- Purpose: Show edit form pre-filled with existing data
- Fetches footprint by ID and passes to edit-footprint.blade.php

**5. update($id) - Save Changes**
- Purpose: Update existing footprint
- Process: Same as store() but updates existing record instead

**6. destroy($id) - Delete Entry**
- Purpose: Remove footprint from database
- Finds footprint by ID and deletes it

**7. exportCsv() - Export Data**
- Purpose: Generate and download CSV file
- Creates streamed response with all filtered footprints in CSV format
- Columns: id, travel_km, electricity_units, food_score, water_usage, carbon_value, impact_level, ml_prediction, recommendation, notes, created_at

**Helper Methods:**

**calculateEcoScore($carbon)** - Converts average carbon value to 0-100 score
- < 5 kg: 90-100 (Excellent)
- 5-15 kg: 60-89 (Good to Fair)
- > 15 kg: 10-59 (Poor)

**classifyImpact($carbon)** - Rule-based impact classification
- < 5 kg: "Low Impact"
- 5-15 kg: "Medium Impact"
- > 15 kg: "High Impact"

**predictMlImpact($features, $carbon)** - Calls ML service
- Checks if ML_SERVICE_URL is configured in .env
- POSTs features to Flask service at `/predict`
- Returns label if successful, null if fails (falls back to classification)

**generateRecommendation($features, $carbon, $prediction)** - Creates advice
- Different recommendations for Low/Medium/High impact
- Additional recommendations based on high water usage

### Routes

**Web Routes (`routes/web.php`):**
- `GET /` - Welcome/landing page
- `GET /dashboard` - Main dashboard (auth required)
- `GET /add` - Add footprint form
- `POST /store` - Store new footprint
- `GET /edit/{id}` - Edit form
- `POST /update/{id}` - Update footprint
- `GET /delete/{id}` - Delete footprint
- `GET /export` - Export CSV
- `GET /profile` - User profile (auth required)
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete account

**Auth Routes (`routes/auth.php`):**
- `GET /register` - Registration form
- `POST /register` - Create new user
- `GET /login` - Login form
- `POST /login` - Authenticate user
- `GET /forgot-password` - Password reset request
- `POST /forgot-password` - Send reset email
- `GET /reset-password/{token}` - Password reset form
- `POST /reset-password` - Update password
- `GET /verify-email` - Email verification notice
- `GET /verify-email/{id}/{hash}` - Verify email token
- `POST /logout` - Sign out user

### Form Validation (FormRequests)

**StoreFootprintRequest** - Validates input when adding/editing
- travel_km: required, numeric, >= 0
- electricity_units: required, numeric, >= 0
- food_score: required, numeric, >= 0
- water_usage: required, numeric, >= 0
- notes: optional, string

**UpdateFootprintRequest** - Same validation as store

---

## 7. FRONTEND IMPLEMENTATION

### Blade Templates (View Layer)

#### layout.blade.php - Master Template

The main layout wrapping all pages. Contains:
- `<head>`: Bootstrap, Chart.js, Bootstrap Icons, Fonts (Poppins)
- Navbar: Navigation with dashboard link, add footprint button, theme toggle
- `@yield('content')`: Where child template content goes
- `@yield('scripts')`: Where child template JavaScript goes
- Theme toggle script: Switches between light/dark mode using localStorage

#### welcome.blade.php - Landing Page

Modern glassmorphism design with split-screen layout:

**Left Side (Brand Section):**
- Floating animated logo (🌿)
- Title: "Carbon Footprint Tracker"
- Subtitle: "Track your emissions and build a greener future"
- Animated eco icons (🌍 🌱 ⚡ 🚗 💧)

**Right Side (Forms Section):**
- Tab interface: Login / Register tabs
- Login form: Email, password, remember me checkbox
- Register form: Name, email, password, confirm password
- Smooth tab switching with fade animations
- Error/success messages displayed in styled boxes
- Forms post to Laravel auth routes

**Design Features:**
- Gradient background (green ecological theme)
- Glassmorphism cards (blur effect, transparency)
- Responsive: Single column on mobile, two-column on desktop
- Smooth animations and hover effects

#### dashboard.blade.php - Main Dashboard

Complete user dashboard with multiple sections:

**Header Section:**
- Welcome message with "Add New Footprint" button
- Uses `@extends('layout')` to inherit master layout

**Statistics Cards (Row 1):**
- Eco Score: 0-100 scale with progress bar
- Total CO2 Emitted: Sum of all entries
- Peak Emission: Highest single entry

**Charts Section (Row 2):**
- **CO2 Over Time** (Line Chart): Shows emissions trend by date
- **Impact Distribution** (Pie Chart): Low/Medium/High breakdown
- **Impact by Category** (Bar Chart): Travel/Electricity/Food/Water

**AI Insights & Leaderboard (Row 3):**
- Smart insights: Generated messages about emission patterns
- Eco leaderboard: Top 5 lowest-carbon entries ranked

**Filter & Export (Row 4):**
- Date range filter (from/to)
- Impact level filter (Low/Medium/High)
- CSV export button
- Apply filters button

**Footprint Records Table (Row 5):**
- Responsive table showing all entries
- Columns: #, Travel, Electricity, Food, Water, Carbon, Impact, Prediction, Created, Actions
- Sticky Actions column on scroll
- Color-coded badges for impact/prediction
- Edit and Delete buttons for each row
- Pagination with Laravel links

**Chart.js Integration:**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Wait for DOM ready
    const co2Labels = @json($co2HistoryLabels);
    const co2Data = @json($co2HistoryData);
    
    // Create line chart
    new Chart(ctx, {
        type: 'line',
        data: { labels: co2Labels, datasets: [{...}] },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
```

#### add-footprint.blade.php - Add Form

Form for creating new entries with fields:
- Travel distance (km)
- Electricity units (kWh)
- Food score (1-10)
- Water usage (liters)
- Notes (optional)

Bootstrap form validation with error highlighting.

#### edit-footprint.blade.php - Edit Form

Pre-filled form identical to add form but edits existing entry.

### Styling (CSS)

**Bootstrap 5 + Custom CSS:**
- Color scheme: Green eco theme (#7be49f primary)
- Cards: Glassmorphism with backdrop blur
- Buttons: Gradient fills with hover animations
- Tables: Transparent backgrounds with hover effects
- Badges: Color-coded (Green/Yellow/Red)
- Forms: Rounded inputs with focus states
- Animations: Fade-in, slide, scale effects

**Responsive Design:**
- Mobile-first approach
- Breakpoints: xs, sm (576px), md (768px), lg (992px), xl (1200px)
- Hidden columns on small screens using Bootstrap's d-none/d-md-table-cell
- Sticky actions column on table scroll
- Full-screen hero layouts

---

## 8. MACHINE LEARNING INTEGRATION

### ML Service Architecture

**Location**: `ml_service/` directory

**Components:**

**1. train.py - Model Training Script**
- Generates synthetic dataset with random carbon features
- Creates labels based on thresholds (Low/Medium/High)
- Trains Random Forest classifier with the data
- Saves trained model to `model.pkl` using joblib
- Can be re-run to create updated models

**2. app.py - Flask API Server**
- Starts Flask web server on port 5000
- Defines `POST /predict` endpoint
- Receives JSON with features: `{ travel_km, electricity_units, food_score, water_liters, carbon_value }`
- Loads `model.pkl` into memory
- Uses model to predict impact label
- Returns JSON: `{ "label": "Low Impact" }`

**3. model.pkl - Trained Model File**
- Binary file containing serialized Random Forest model
- Created by `train.py` using joblib
- Loaded by `app.py` for predictions

**4. requirements.txt - Python Dependencies**
```
flask              # Web framework
scikit-learn       # ML library
joblib            # Model serialization
pandas            # Data manipulation
numpy             # Numerical computing
```

### Integration with Laravel

**Flow:**
1. User submits footprint form in Laravel
2. Controller calculates carbon value
3. Controller calls `predictMlImpact($features, $carbon)`
4. Function checks if `ML_SERVICE_URL` is set in .env
5. If configured, POSTs to `http://ML_SERVICE_URL/predict` with features
6. Receives JSON response with label
7. Stores prediction in database
8. If ML service unavailable or times out, falls back to rule-based classification

**Configuration in .env:**
```env
ML_SERVICE_URL=http://127.0.0.1:5000
```

**Fallback Mechanism:**
- If ML service not configured: Uses rule-based impact levels
- If ML service unavailable: Catches exception and returns null
- Falls back to `$mlPrediction ?? $impact` (uses impact as fallback)

### Training vs. Serving Split

**Training (One-time or Periodic):**
- Data scientist runs `python train.py`
- Takes raw data and creates model
- Saves model.pkl

**Serving (Runtime):**
- `python app.py` runs continuously
- Loads model.pkl on startup
- Responds to prediction requests instantly
- No retraining needed per request

---

## 9. USER FLOW & WORKFLOWS

### Complete User Journey

#### Workflow 1: New User Registration

```
1. User visits http://localhost:8000/
   ↓
2. Sees landing page with login/register forms
   ↓
3. Clicks "Register" tab
   ↓
4. Fills in: Name, Email, Password, Confirm Password
   ↓
5. Clicks "Create Account" button
   ↓
6. Form posts to /register route
   ↓
7. RegisteredUserController validates input
   ↓
8. Creates new User record in database with hashed password
   ↓
9. Logs user in automatically
   ↓
10. Redirects to /dashboard (empty state - no entries yet)
   ↓
11. User sees message: "No records yet. Click Add Footprint to create one."
```

#### Workflow 2: Existing User Login

```
1. User visits http://localhost:8000/
   ↓
2. Clicks "Login" tab
   ↓
3. Enters email and password
   ↓
4. Optionally checks "Remember me"
   ↓
5. Clicks "Sign In"
   ↓
6. Form posts to /login route
   ↓
7. AuthenticatedSessionController checks credentials
   ↓
8. If password matches: Creates session and redirects to /dashboard
   ↓
9. If invalid: Shows error message and stays on login page
```

#### Workflow 3: Adding a Footprint Entry

```
1. User logs in and sees dashboard
   ↓
2. Clicks "Add New Footprint" button
   ↓
3. Browser navigates to /add
   ↓
4. FootprintController@create returns add-footprint.blade.php
   ↓
5. User fills form:
   - Travel: 25 km
   - Electricity: 12 kWh
   - Food: 6 score
   - Water: 50 liters
   - Notes: "Daily commute"
   ↓
6. Clicks Submit
   ↓
7. Form validates using StoreFootprintRequest
   - If errors: Form re-displayed with error messages
   ↓
8. FootprintController@store calculates:
   - Carbon = (25 × 0.21) + (12 × 0.85) + (6 × 1.5) + (50 × 0.05)
   - Carbon = 5.25 + 10.2 + 9 + 2.5 = 26.95 kg
   ↓
9. Classifies impact:
   - 26.95 > 15, so "High Impact"
   ↓
10. Calls ML service (if configured):
    - POSTs features to /predict
    - Gets response: { "label": "High Impact" }
    ↓
11. Generates recommendation:
    - "High impact detected — reduce travel and electricity..."
    ↓
12. Creates Footprint record in database
    ↓
13. Redirects to /dashboard with "Data Added Successfully" message
    ↓
14. Dashboard reloads showing:
    - New entry in table
    - Charts updated with new data
    - Statistics recalculated
```

#### Workflow 4: Viewing Dashboard Analytics

```
1. User navigates to /dashboard
   ↓
2. FootprintController@index queries database
   ↓
3. Fetches all footprints ordered by created_at DESC
   ↓
4. Groups by date and sums CO2 for timeline
   ↓
5. Calculates totals, averages, and peak values
   ↓
6. Counts impact distribution
   ↓
7. Computes category totals and percentages
   ↓
8. Calculates eco-score based on average carbon
   ↓
9. Generates 3 AI insights about patterns
   ↓
10. Gets top 5 lowest-carbon entries for leaderboard
    ↓
11. Returns all data to Blade template via compact()
    ↓
12. Blade renders HTML with:
    - Metric cards with statistics
    - Charts initialized with @json($data)
    - Table of entries with pagination
    - Filters and export button
    ↓
13. Browser loads page
    ↓
14. Chart.js initializes with DOM ready event
    ↓
15. Three charts render:
    - Line chart of CO2 over time
    - Doughnut pie chart of impact distribution
    - Bar chart of category emissions
    ↓
16. User sees complete dashboard with interactive charts
```

#### Workflow 5: Editing an Entry

```
1. User clicks "Edit" button next to table row
   ↓
2. Browser navigates to /edit/3 (where 3 is entry ID)
   ↓
3. FootprintController@edit fetches footprint #3
   ↓
4. Passes data to edit-footprint.blade.php
   ↓
5. Form displays pre-filled with existing values
   ↓
6. User modifies values and clicks Save
   ↓
7. Form posts to /update/3
   ↓
8. FootprintController@update recalculates:
   - Carbon value
   - Impact classification
   - ML prediction
   - Recommendation
   ↓
9. Updates database record
   ↓
10. Redirects to dashboard with "Updated Successfully" message
```

#### Workflow 6: Exporting Data

```
1. User sees Filter section with "Export CSV" button
   ↓
2. User optionally sets filters (date range, impact level)
   ↓
3. Clicks "Export CSV"
   ↓
4. Browser navigates to /export?date_from=...&impact=...
   ↓
5. FootprintController@exportCsv processes request
   ↓
6. Creates StreamedResponse with:
   - Header: Content-Type: text/csv
   - Header: Content-Disposition: attachment
   - Name: footprints_20260602_120000.csv
   ↓
7. Iterates through filtered footprints
   ↓
8. Writes each row to CSV format
   ↓
9. Browser downloads file automatically
   ↓
10. User can open in Excel, Google Sheets, or text editor
```

---

## 10. INSTALLATION & SETUP

### Prerequisites
- PHP 8.2 or higher
- Composer (PHP package manager)
- Node.js 16+ with npm
- Python 3.8+ (for ML service)
- SQLite (included with PHP)

### Step 1: Clone Project
```bash
cd c:\Users\Hp\carbon_project
```

### Step 2: Install PHP Dependencies
```bash
composer install
```
This installs Laravel and all required PHP packages listed in composer.json.

### Step 3: Setup Environment File
```bash
copy .env.example .env
```
Edit `.env` and configure if needed (defaults work for development).

### Step 4: Generate Application Key
```bash
php artisan key:generate
```
Creates unique encryption key for the application.

### Step 5: Create Database & Tables
```bash
php artisan migrate
```
Runs all migration files to create tables in SQLite database.

### Step 6: Install Frontend Dependencies
```bash
npm install
```
Installs JavaScript and CSS packages.

### Step 7: Build Frontend Assets
```bash
npm run build
```
Compiles Tailwind CSS and JavaScript for production.

### Step 8: Start Development Server
```bash
php artisan serve
```
Starts Laravel development server on http://localhost:8000

### Step 9: Setup ML Service (Optional)
```bash
cd ml_service
python -m venv venv
venv\Scripts\activate          # Windows
pip install -r requirements.txt
python train.py                # Train model
python app.py                  # Start Flask server on port 5000
```

### Step 10: Configure ML Integration
Edit `.env` and add:
```env
ML_SERVICE_URL=http://127.0.0.1:5000
```

---

## 11. API ENDPOINTS

### Public Routes (No Authentication Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | / | Welcome/landing page |
| GET | /register | Registration form |
| POST | /register | Create new user account |
| GET | /login | Login form |
| POST | /login | Authenticate user |
| GET | /forgot-password | Password reset request form |
| POST | /forgot-password | Send password reset email |
| GET | /reset-password/{token} | Password reset form |
| POST | /reset-password | Update user password |

### Protected Routes (Authentication Required)

| Method | Endpoint | Description | Returns |
|--------|----------|-------------|---------|
| GET | /dashboard | Main dashboard | HTML dashboard page with charts and statistics |
| GET | /add | Add footprint form | HTML form template |
| POST | /store | Create footprint | Redirect to dashboard |
| GET | /edit/{id} | Edit form | HTML form pre-filled with data |
| POST | /update/{id} | Update footprint | Redirect to dashboard |
| GET | /delete/{id} | Delete footprint | Redirect to dashboard |
| GET | /export | Export CSV | CSV file download |
| GET | /profile | Edit profile | HTML profile form |
| PATCH | /profile | Update profile | Redirect to dashboard |
| DELETE | /profile | Delete account | Redirect to home |

### ML Service Endpoints (Flask, Port 5000)

| Method | Endpoint | Request Body | Response |
|--------|----------|--------------|----------|
| POST | /predict | `{ "travel_km": 10, "electricity_units": 20, "food_score": 5, "water_liters": 50, "carbon_value": 12.5 }` | `{ "label": "Low Impact" }` |

---

## 12. HOW EVERYTHING WORKS TOGETHER

### Complete Data Flow Example: User Adds Entry

```
User fills form and clicks Submit
           ↓
Browser creates FormData and POSTs to /store
           ↓
Laravel Router (web.php) matches POST /store → FootprintController@store
           ↓
Middleware (auth) checks session - user logged in? Yes → Continue
           ↓
StoreFootprintRequest validates input:
- travel_km numeric? ✓
- electricity_units numeric? ✓
- All values positive? ✓
           ↓
FootprintController@store executes:

1. Extract validated data:
   $data = ['travel_km' => 25, 'electricity_units' => 12, 
            'food_score' => 6, 'water_usage' => 50]

2. Calculate carbon value:
   $carbon = (25 × 0.21) + (12 × 0.85) + (6 × 1.5) + (50 × 0.05)
   $carbon = 5.25 + 10.2 + 9 + 2.5 = 26.95 kg

3. Classify impact (rule-based):
   if (26.95 < 5) → Low Impact
   elseif (26.95 <= 15) → Medium Impact
   else → High Impact ✓
   $impact = "High Impact"

4. Try ML prediction:
   if (env('ML_SERVICE_URL')) {
       $mlUrl = "http://127.0.0.1:5000"
       POST to $mlUrl/predict with features
       Try block:
           - Connect to Flask service
           - Send features as JSON
           - Receive response: { "label": "High Impact" }
           - Extract label
       Catch block (if service down):
           - Return null (fallback to classification)
   }
   $mlPrediction = "High Impact" (from ML) OR null

5. Decide prediction to store:
   $predictionToStore = $mlPrediction ?? $impact
   $predictionToStore = "High Impact" ??  "High Impact"
   $predictionToStore = "High Impact"

6. Generate recommendation:
   Since $prediction == "High Impact":
   - Add: "High impact detected — reduce travel..."
   - Add: "Use energy-saving appliances..."
   - Since water_usage (50) < 100: Don't add water note
   $recommendation = "High impact detected... Use energy-saving..."

7. Create database record:
   Footprint::create([
       'travel_km' => 25,
       'electricity_units' => 12,
       'food_score' => 6,
       'water_usage' => 50,
       'carbon_value' => 26.95,
       'impact_level' => "High Impact",
       'ml_prediction' => "High Impact",
       'recommendation' => "High impact detected...",
       'notes' => "Daily commute"
   ])
   
   Eloquent ORM executes SQL INSERT:
   INSERT INTO footprints (travel_km, electricity_units, ...)
   VALUES (25, 12, 6, 50, 26.95, 'High Impact', ...)
   
   SQLite stores record with auto-generated ID #42

8. Return response:
   return redirect('/dashboard')->with('success', 'Data Added...')
           ↓
Browser receives redirect response (HTTP 302)
           ↓
Browser navigates to /dashboard
           ↓
GET /dashboard request sent
           ↓
Laravel Router matches GET /dashboard → FootprintController@index
           ↓
Middleware checks auth - User logged in? Yes → Continue
           ↓
FootprintController@index executes:

1. Query all footprints:
   $query = Footprint::query()
   (Optional) Apply filters if provided
   $footprints = $query->orderByDesc('created_at')->get()

2. Calculate totals:
   $totalCO2 = Footprint::sum('carbon_value')
   // = 26.95 + 18.05 + 19.16 = 64.16 kg

3. Calculate averages:
   $averageCO2 = Footprint::avg('carbon_value')
   // = 64.16 / 3 = 21.39 kg

4. Find peak:
   $highest = Footprint::orderByDesc('carbon_value')->first()
   // Entry #42 with 26.95 kg

5. Build timeline:
   SELECT date(created_at) as date, sum(carbon_value) as total_co2
   FROM footprints
   GROUP BY date
   ORDER BY date
   // Returns one row per day with daily totals

6. Format labels for charts:
   $co2HistoryLabels = ['Jun 02', 'Jun 01', ...]
   $co2HistoryData = [26.95, 37.21, ...]

7. Count impact distribution:
   Low Impact: 0
   Medium Impact: 1  
   High Impact: 2

8. Calculate eco-score:
   averageCO2 = 21.39 kg
   Since 15 < 21.39:
   ecoScore = 59 - round(min((21.39-15)*1.5, 49))
   ecoScore = 59 - 10 = 49/100 (Fair)

9. Generate insights:
   [ "High impact detected - reduce emissions",
     "Travel is your highest source...",
     "Your latest entry is 30% higher than previous..." ]

10. Get leaderboard:
    SELECT * FROM footprints ORDER BY carbon_value LIMIT 5
    Top 5 lowest-carbon entries

11. Return data to view:
    return view('dashboard', compact(
        'data',           // Paginated entries
        'totalCO2',       // 64.16
        'averageCO2',     // 21.39
        'highest',        // Entry object
        'co2HistoryLabels', // Dates
        'co2HistoryData',   // Values
        'lowCount', 'mediumCount', 'highCount',
        'categoryTotals',
        'smartInsights',
        'ecoScore',
        'levelLabel',
        'progressWidth',
        'leaderboard'
    ));
           ↓
Blade template (dashboard.blade.php) renders:

1. Pass data to HTML:
   <h1>{{ $totalCO2 }} kg</h1> → <h1>64.16 kg</h1>
   <h2>{{ $ecoScore }}/100</h2> → <h2>49/100</h2>

2. Render table rows:
   @foreach($data as $item)
       <tr>
           <td>{{ $item->id }}</td> → <td>42</td>
           <td>{{ $item->carbon_value }} kg</td> → <td>26.95 kg</td>
           ...
       </tr>
   @endforeach

3. Initialize charts with data:
   <script>
   const co2Labels = @json($co2HistoryLabels)
   // ["Jun 02", "Jun 01", ...]
   
   new Chart(ctx, {
       type: 'line',
       data: {
           labels: co2Labels,
           datasets: [{
               label: 'CO2 (kg)',
               data: @json($co2HistoryData)
               // [26.95, 37.21, ...]
           }]
       }
   });
   </script>

4. Send complete HTML to browser
           ↓
Browser receives HTML
           ↓
Browser parses HTML and executes JavaScript
           ↓
Chart.js initializes charts:
- Line chart: Shows trend over days
- Pie chart: Low (0), Medium (1), High (2)
- Bar chart: Travel/Electricity/Food/Water values
           ↓
Browser renders complete dashboard with:
- Statistics cards updated with new totals
- Charts visualizing entry data
- Table showing all entries including new one
- Filters and export button
           ↓
User sees updated dashboard in browser
```

### Key Technologies Working Together

1. **PHP/Laravel** - Processes requests, calculates carbon, manages data
2. **SQLite Database** - Stores all data persistently
3. **Blade Templates** - Renders HTML with dynamic data
4. **Bootstrap 5** - Styles the interface responsively
5. **Chart.js** - Visualizes data in interactive charts
6. **JavaScript** - Handles client-side interactions and tab switching
7. **Python/Flask** - Provides ML predictions (optional)
8. **scikit-learn** - Powers the Random Forest model

### Database Interaction Pattern

All data flows through Eloquent ORM:
```
User Input → Controller → Validation → Eloquent Model → SQL → SQLite → Storage
Browser ← HTML View ← Query Results ← Eloquent Model ← SQL ← SQLite ← Data
```

---

## SUMMARY

The **Carbon Footprint Tracker** is a full-stack web application that:

1. **Accepts user input** through Blade-rendered forms
2. **Validates data** using Laravel FormRequests
3. **Calculates carbon values** using mathematical formulas in the controller
4. **Classifies impact** using rule-based and ML-based methods
5. **Stores everything** in SQLite database through Eloquent ORM
6. **Displays results** through interactive Blade templates and Chart.js visualizations
7. **Enables exports** through CSV streaming
8. **Provides recommendations** through rule-based generation
9. **Offers analytics** through aggregated queries and statistics
10. **Scales predictions** through optional ML service integration

The project demonstrates modern full-stack web development with separation of concerns: separate models for data, controllers for logic, views for presentation, and optional microservices for specialized tasks like machine learning.

