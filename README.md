## Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/ChouMonyrith/Sound-Core
   ```

2. **Navigate to the project directory**
   ```bash
   cd Sound-Core
   ```

3. **Install the dependencies**
   - Install Node.js packages:
     ```bash
     npm install
     ```
   - Install PHP Composer packages:
     ```bash
     composer install
     ```

4. **Create a new `.env` file**  
   Copy `.env.example` to `.env` (if available), and configure your database and other settings.

5. **Run database migrations**
   ```bash
   php artisan migrate
   ```

6. **Link storage**
   ```bash
   php artisan storage:link
   ```

7. **Run the project**
   - Start the frontend development server:
     ```bash
     npm run dev
     ```
   - Start the Laravel backend server:
     ```bash
     php artisan serve
     ```

---

Make sure you have Node.js, npm, Composer, and PHP installed on your system before starting these steps.
