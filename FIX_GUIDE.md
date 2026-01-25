# iMarket Error Fix Guide

## Issues Identified
Based on the browser console errors, the following issues were detected:

1. **Invalid Regular Expression Error** (Line 1140)
2. **Failed to load resources:**
   - `logo.webp1` (404 error)
   - `favicon.ico1` (404 error)

## Root Cause
The errors suggest:
- File path concatenation issues causing "1" to be appended to filenames
- Possible server-side caching serving outdated/corrupted content
- Potential regex syntax error in JavaScript code

## Fixes Applied

### 1. Updated Index Files
- ✅ Cleaned up `index.html` with proper relative paths
- ✅ Removed version parameters from `index.php` that might cause concatenation issues
- ✅ Added error handling for image loading

### 2. Enhanced .htaccess
- ✅ Added rewrite rule to handle files with "1" appended
- ✅ Set proper MIME types for images
- ✅ Enhanced cache control headers
- ✅ Added compression support

### 3. Created Utility Scripts
- ✅ `clear-cache.php` - Clears server-side caches
- ✅ `diagnostics.php` - Comprehensive system diagnostics

## How to Fix (Step-by-Step)

### Step 1: Upload Updated Files
Upload the following files to your server:
- `index.html`
- `index.php`
- `.htaccess`
- `clear-cache.php`
- `diagnostics.php`

### Step 2: Clear Server Cache
1. Visit: `https://core1.imarketph.com/clear-cache.php`
2. This will clear OPcache and set fresh headers

### Step 3: Run Diagnostics
1. Visit: `https://core1.imarketph.com/diagnostics.php`
2. Check for any red errors
3. Verify all files are found and loading correctly

### Step 4: Clear Browser Cache
**Chrome/Edge:**
- Press `Ctrl + Shift + Delete` (Windows) or `Cmd + Shift + Delete` (Mac)
- Select "Cached images and files"
- Click "Clear data"

**Or use Hard Refresh:**
- Windows: `Ctrl + F5`
- Mac: `Cmd + Shift + R`

### Step 5: Verify Fix
1. Visit: `https://core1.imarketph.com`
2. Open Developer Tools (F12)
3. Check Console tab - should be no errors
4. Check Network tab - all resources should load with 200 status

## Additional Troubleshooting

### If errors persist:

#### Check Server Error Logs
Look for PHP errors in your hosting control panel (cPanel, Plesk, etc.)

#### Verify File Permissions
```bash
# Files should be 644
chmod 644 index.php index.html .htaccess

# Directories should be 755
chmod 755 php Components css image
```

#### Check for Conflicting Code
Search for any code that might be appending "1" to file paths:
```bash
grep -r "logo.webp" .
grep -r "favicon.ico" .
```

#### Disable Plugins/Extensions
If using any server-side optimization plugins:
- Temporarily disable minification
- Disable asset combining
- Disable lazy loading

### If using CloudFlare or CDN:
1. Purge all cache in CloudFlare dashboard
2. Temporarily set Development Mode
3. Wait 5 minutes and test again

## Prevention

To prevent similar issues in the future:

1. **Always use relative paths** without version parameters in production
2. **Test locally** before deploying to live server
3. **Use version control** (Git) to track changes
4. **Monitor error logs** regularly
5. **Keep backups** of working versions

## Need More Help?

If issues persist after following these steps:
1. Check the diagnostics output for specific errors
2. Review server error logs
3. Contact your hosting provider if it's a server configuration issue

## Files Modified
- ✅ index.html
- ✅ index.php
- ✅ .htaccess

## Files Created
- ✅ clear-cache.php
- ✅ diagnostics.php
- ✅ FIX_GUIDE.md (this file)

---
Last Updated: 2026-01-25
