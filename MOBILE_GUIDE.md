# How to Convert Your Laravel App to a Mobile APK

Since your application is built with **Laravel (PHP)**, it runs on a **server** (server-side rendering). Android phones cannot execute PHP code directly.

To turn this into an app (APK), you generally have two options:

## Option 1: Progressive Web App (PWA) - **Recommended**
This makes your website "installable" on Android/iOS. It adds an icon to the home screen and removes the browser address bar, making it look and feel like an app.

**Steps:**
1.  **Host your app**: Deploy your Laravel app to a real server (DigitalOcean, Linode, Heroku, etc.) so it has a public `https://...` URL.
2.  **Add Manifest**: Create a `manifest.json` file.
3.  **Add Service Worker**: Enable offline capabilities.
4.  **Install**: Users visit the site and click "Add to Home Screen".

## Option 2: Capacitor / Cordova (WebView Wrapper)
This wraps your **hosted** website inside a native Android container. It creates a real `.apk` file you can upload to the Play Store.

### Prerequisites
1.  **Host your app**: You MUST host the Laravel app online first.
2.  **Node.js**: Installed on your computer.
3.  **Android Studio**: Installed to build the APK.

### Steps to Build APK (using Capacitor)

1.  **Install Capacitor** in your project root:
    ```bash
    npm init @capacitor/app
    ```
    - Answer the prompts (Name: "Prayer App", ID: "com.yaschools.prayer").

2.  **Install Android Platform**:
    ```bash
    npm install @capacitor/android
    npx cap add android
    ```

3.  **Configure Capacitor**:
    Open `capacitor.config.json` and change `webDir` to `public` (or leave it), but most importantly, set the `server` url to your **hosted application URL**:
    ```json
    {
      "appId": "com.yaschools.prayer",
      "appName": "Prayer App",
      "webDir": "public",
      "server": {
        "url": "https://your-live-website.com",
        "cleartext": true
      }
    }
    ```

4.  **Build**:
    ```bash
    npx cap open android
    ```
    This opens Android Studio. From there, you can go to **Build > Build Bundle(s) / APK(s) > Build APK**.

## Why can't I build it offline?
Because your app uses PHP (`PrayerController.php`), it needs a web server (Apache/Nginx) and PHP engine to run. A standard Android app relies on Java/Kotlin/JS. 

**Conclusion:**
1.  **First Step**: Deploy your website to the internet.
2.  **Second Step**: Use the browser's "Add to Home Screen" OR use Capacitor to wrap that URL into an APK.
