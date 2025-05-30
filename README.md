# Disease Database System

This project is a web-based application designed to manage and retrieve data from a disease database. It provides an intuitive interface for users to perform searches, export data, and explore disease details.

## Project Structure

- **`homepage.html`**: The main landing page of the application. It contains links to other pages such as search, export, and help.
- **`search.html`**: A page where users can perform searches on the database.
- **`export.html`**: A page that allows users to export data from the database in various formats.
- **`connectToDB.php`**: A PHP script that establishes a connection to the database using provided credentials.
- **`performSearch.php`**: A placeholder PHP script intended to handle search queries and return results.
- **`homepage_stylesheet.css`**: Stylesheet for the homepage.
- **`search_stylesheet.css`**: Stylesheet for the search page.
- **`export_stylesheet.css`**: Stylesheet for the export page.
- **`.vscode/settings.json`**: Configuration file for Visual Studio Code.

## Features

1. **Homepage**:
   - Provides quick links to key functionalities.
   - Styled with `homepage_stylesheet.css`.

2. **Search**:
   - Allows users to search the database using a query.
   - Styled with `search_stylesheet.css`.

3. **Export**:
   - Enables exporting data in formats like CSV, JSON, XML, and PDF.
   - Styled with `export_stylesheet.css`.

4. **Database Connection**:
   - `connectToDB.php` handles the connection to the database using PDO.

## How to Run

1. Ensure you have a web server (e.g., Apache) and PHP installed.
2. Place the project files in the web server's root directory.
3. Update the database credentials in `connectToDB.php` to match your database configuration.
4. Open `homepage.html` in a browser to start using the application.

## Future Improvements

- Implement the logic in `performSearch.php` to handle search queries.
- Add functionality to export data in the specified formats in `export.html`.
- Create additional pages like `help.html` and `diseaseDetails.html`.

## License

This project is part of the Applied Databases Group Project 2025 and is intended for educational purposes.
