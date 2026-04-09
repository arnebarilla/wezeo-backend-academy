# Wezeo Backend Academy
## PHP
### L1 : Logger 1

An application for logging student arrivals at school. Every time the script is run, the current time is recorded and the following logic applies:
- arrivals at or before **8:00** are recorded as on time
- arrivals after **8:00** up to and including **20:00** are recorded with a note `meškanie`
- arrivals after **20:00** are **not recorded**
All arrivals are persisted in a JSON file and displayed on every page load.

**How to run:**
1. Install [MAMP](https://www.mamp.info/)
2. Copy the `l1-logger` folder into `MAMP/htdocs/`
3. Start MAMP
4. Open browser and navigate to `http://localhost/l1-logger/logger1.php`