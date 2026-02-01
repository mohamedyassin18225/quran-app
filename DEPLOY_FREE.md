# Free Hosting Options for Laravel

Here are the best ways to host your Laravel app for **free**.

## Option 1: Render.com (Recommended)
Render is a cloud provider that offers a "Free" tier for Web Services.

1.  **Push your code to GitHub/GitLab**.
    - If you haven't, initialize git: `git init`, `git add .`, `git commit -m "ready"`.
    - Create a repo on GitHub and push.

2.  **Sign up at [Render.com](https://render.com)**.

3.  **New Web Service**:
    - Click **"New +"** -> **"Web Service"**.
    - Connect your GitHub repository.

4.  **Settings**:
    - **Name**: `prayer-app` (or similar)
    - **Runtime**: `PHP` (It might detect Docker, but select PHP if possible or let it auto-detect).
    - **Build Command**: `composer install --no-dev --optimize-autoloader`
    - **Start Command**: `heroku-php-apache2 public/` (Render supports Heroku buildpacks so this usually works, or defaults to built-in commands).
    - **Free Instance Type**: Select the "Free" tier.

5.  **Environment Variables** (Advanced):
    - Key: `APP_KEY` -> Value: (Copy from your `.env` file or run `php artisan key:generate --show`)
    - Key: `APP_DEBUG` -> Value: `true` (for now) or `false`
    - Key: `APP_ENV` -> Value: `production`

6.  **Deploy**: Click "Create Web Service".

*Note: The free tier on Render spins down after 15 minutes of inactivity, so the first load might take 30 seconds.*

---

## Option 2: Vercel (Fast & Good for Hobby)
Vercel is great, but requires a small config for PHP.

1.  **Create `vercel.json`** in your project root:
    ```json
    {
        "version": 2,
        "framework": null,
        "functions": {
            "api/index.php": { "runtime": "vercel-php@0.6.0" }
        },
        "routes": [
            {
                "src": "/(.*)",
                "dest": "/api/index.php"
            }
        ],
        "env": {
            "APP_ENV": "production",
            "APP_DEBUG": "true",
            "APP_URL": "https://your-app.vercel.app",
            "APP_KEY": "base64:YOUR_GENERATED_KEY_HERE"
        }
    }
    ```
2.  **Create `api/index.php`**:
    - You need to bridge the Vercel request to Laravel.
    - Create folder `api` and file `index.php` inside it:
    ```php
    <?php
    // Forward Vercel requests to Laravel's public/index.php
    require __DIR__ . '/../public/index.php';
    ```
3.  **Deploy**:
    - Install CLI: `npm i -g vercel`
    - Run: `vercel`

## Important Note on Database
Your current app **does NOT uses a database** (it fetches from API), so deployment is very easy! You don't need to worry about MySQL hosting.
