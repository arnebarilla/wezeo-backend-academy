# PHP Logger 2

A simple student arrival logger built in PHP. Students can log in by name, record their arrivals, and log out. An admin view (`all`) shows all recorded arrivals across all students.

## Project Structure

```
.
├── index.php       # Login form
├── profile.php     # Student dashboard (record arrival, log out)
├── arrival.php     # Arrival class – logic for recording and displaying arrivals
├── student.php     # Student class – logic for managing students
├── helper.php      # Helper class – shared file utilities
├── arrivals.json   # Stores all arrival records (auto-generated, git-ignored)
├── students.json   # Stores all student records (auto-generated, git-ignored)
└── .gitignore
```

## Features

- Log in by entering a student name
- Record arrivals with a button (only allowed between 00:00 and 20:00)
- Arrivals before or at 08:00 are marked as **on time**, after 08:00 as **late**
- View your total arrival count after logging in
- Log out to return to the login screen
- Log in as `all` to view every recorded arrival across all students

## How to Run

Requires a local PHP server (e.g. MAMP, XAMPP, or PHP built-in server).

```bash
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser.

## Data Storage

### `arrivals.json`
Each record contains:
```json
{
  "time": "2026-04-10 08:05:00",
  "student": "john",
  "onTime": false
}
```

### `students.json`
Each record contains:
```json
{
  "student": "john",
  "arrivalsCount": 3
}
```

Both files are excluded from version control via `.gitignore`.

## Notes

- Arrivals after 20:00 are blocked and not saved
- A new student record is created automatically on first login
- The `all` account cannot record arrivals
